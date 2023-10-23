# FileMaker cloud approver #

When you are trying to use the Claris FileMaker Data API with FileMaker Cloud you will often fail to login on a server because the IP address hasn't been approved for that user.

Unfortunately the approval has to be run from the same IP address, which for many servers isn't possible because they're completely headless.

This library and the instructions below solve this problem by installing a headless version of Chrome on your server, then performing the necessary steps to approve the server's IP for the account you're using.

To be perfectly honest, this process is still a hassle, however it does work without having to rely on emailing Claris technical support.

## Installation ##

These instructions presume that you already have PHP 7.4.x or 8.x installed on the server, if not then you're going to need to take care of that first. If you're on PHP 7.4 then the instructions below are for you. If you're using PHP 8.0 then you'll need to use `composer update` in place of `composer install` below.

Step one is to install the headless version of Google Chrome.

```bash
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i google-chrome*.deb
````
If you receive errors about unmet dependencies run
```bash
sudo apt-get -f install
```

Now install the application itself

```bash
git clone https://github.com/matatirosolutions/fm-cloud-approver.git ./fm-cloud-approver
cd fm-cloud-approver/
composer install
vendor/bin/bdi detect drivers
```
## Usage ##

Given that you've gone to the effort to get this far I'm presuming that you already have a 'New Claris ID sign-in attempt' email. Right click on the 'click here' link and copy the URL.

Back in the console you performed the above installation.

```bash
bin/app.php "**paste-link-here**"
```
If you paste the link without putting it in quotes the approval will fail because not all of the parameters will be received by the app correctly.

## Contact ##

See this [blog post](https://msdev.co.uk/fm-cloud-approver) for more details.

Steve Winter  
Matatiro Solutions  
steve@msdev.nz
