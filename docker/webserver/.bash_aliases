# Alias de ls
export LS_OPTIONS='--color=auto'
alias ls='ls $LS_OPTIONS'
alias ll='ls $LS_OPTIONS -l'
alias l='ls $LS_OPTIONS -lA'

## Alias for Symfony
alias console='php bin/console'
alias csfixer='vendor/bin/php-cs-fixer fix'
alias pstan='vendor/bin/phpstan analyse'