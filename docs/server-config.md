# Server configuration

## Building .htaccess

The **[public/htaccess.dist](./public/htaccess.dist)** distributed with the repo combines modules from the **[H5BP Apache Server Configs](https://github.com/h5bp/server-configs-apache)** and Jeff Starr's **[Perishable Press 7G Firewall](https://perishablepress.com/7g-firewall/)**.

This repo uses a *[.htaccess configuration file](./resources/server-configs/htaccess.conf)* located in the **server-configs** directory. This kind of file is described on the [H5BP Apache Server Configs](https://github.com/h5bp/server-configs-apache) project site. Have a look at their docs on how to tweak your *.htaccess* file.

To build a new **public/htaccess.dist** file:

```bash
$ composer htaccess
$ cp public/htaccess.dist public/.htaccess
```

## Custom error pages / ErrorDocument

Do not forget to edit or add your contact data to the HTML files inside the **public/errordocs/** directory. To disable custom error documents, look inside the *[.htaccess configuration file](./resources/server-configs/htaccess.conf)* – you'll find this line:

```text
enable  "resources/server-configs/custom-errorpages.conf"
```

Simply change to `disable …` and rebuild the *.htaccess.* 

## Content-Security-Policy

The web app uses [\Middlewares\CSP middleware](https://github.com/middlewares/csp) for certain routes. The value of the CSP header can be defined in **[configs/csp.dist.yaml](./configs/csp.dist.yaml)** (or *configs/csp.yaml,* respectively).

**The distributed csp.dist.yaml** creates the same CSP headers than those used in the [H5BP Apache Server Configs](https://github.com/h5bp/server-configs-apache) project. Head over to their original content-security snippet: [content-security-policy.conf](https://github.com/h5bp/server-configs-apache/blob/main/h5bp/security/content-security-policy.conf)

