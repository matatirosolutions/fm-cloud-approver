#!/usr/bin/env php
<?php
require __DIR__ . '/../vendor/autoload.php';

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Panther\Client;

(new SingleCommandApplication())
    ->setName('Claris Cloud Approver') // Optional
    ->setVersion('1.0.0') // Optional
    ->addArgument('url', InputArgument::REQUIRED, 'The url emailed to you by Claris')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');
        $io->writeln('Checking the URL, please wait a moment');

        $client = Client::createChromeClient();
        $client->request('GET', $url);

        try {
            $crawler = $client->waitFor('#signin-attempt-radio-1');
            $io->writeln('Looks like the correct form. Stand by.');
        } catch (NoSuchElementException| TimeoutException $e) {
            $io->error("This doesn't appear to be a Claris approval form");
            return Command::FAILURE;
        }
        $crawler->filter('#signin-attempt-radio-1')->click();
        $crawler->filter('#report-invalid-button')->click();

        try {
            $client->waitForElementToContain('.header', 'Great, thanks for letting us know.', 10);
            $io->info('IP address approved');
        } catch (NoSuchElementException | TimeoutException) {
            $io->error('Unable to approve address.');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    })
    ->run();