# email2name
Resolve or discover names from emails using external APIs or local dummy algo

# What is all about?
In order to make effective newsletters, increase their chances to get into users’ inbox and trigger user to open the email, we need to call users by name. Like "Hey, Bob!". This lib allows to get the user’s name out of his email. First of all, it makes request to Spokeo service and if it doesn’t receive the name from there, then it gets the name out of the email address. See the tests.

# По русски
Чтобы делать эффективные рассылки, повысить шансы попадания почты в инбокс юзеру и тригернуть пользователя открыть письмо, 
нужно постараться обратиться к нему по имени. Типа "Привет, Володя". Эта либа позволяет добыть имя из почты. Сначала делается запрос в сервис Spokeo, и если оттуда не приходит имя, то делается вычленение имени из почты. Смотрите тесты

# Usage
* put your emails in emails.txt
* run "php example-resolve.php" go get only resolved emails with names
* run "php example-resolve-and-discover.php" go get all emails with resolved or discovered names
* check resolved.csv for result
