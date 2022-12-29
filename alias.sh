alias lat='cd \\wsl$\Ubuntu\home\marcelofabianov\DEVELOPER\latte && source alias.sh && clear'
alias lat.='cat alias.sh'
alias lat.ip='docker inspect lat_http | grep "IPAddress"'
alias lat.watch="docker compose up"
alias lat.up="docker compose up -d"
alias lat.down="docker compose down"
alias lat.bash="docker exec -it lat bash"
alias lat.exec="docker exec lat"
alias lat.php="lat.exec php"
alias lat.composer="lat.exec composer"
alias lat.captainhook="lat.php ./vendor/bin/captainhook"
alias lat.lint="lat.php ./vendor/bin/pint"
alias lat.psalm="lat.php ./vendor/bin/psalm"
alias lat.pest="lat.php ./vendor/bin/pest"
alias lat.lpp="lat.lint && lat.psalm && lat.pest"
alias lat.cover="lat.pest --coverage-clover=coverage.xml"
