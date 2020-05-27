# Repository Sha lookup

## Preface
.env file has been added to the repository intentionally for recruitment process only.

### Installing
```
composer install
```


###How it works

Run in the root folder

```
bin/console app:repository-sha owner/repo branch [--service=github|other]
```

###Tests done
Tests have been done on: 

```
bin/console app:repository-sha lexik/LexikJWTAuthenticationBundle master
```


### fixing styling

```
vendor/bin/ecs check src --fix
```

## Authors

* **Jakub Babiuch** 



