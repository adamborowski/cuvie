export PGPASSWORD=$CUVIE_PGPASSWORD
c='psql -h ec2-107-20-159-103.compute-1.amazonaws.com -U srrceiazwsthqh d9ubjsqe1eg545'
clean="$c -c 'delete from entry; delete from currency;'"
send_currency="$c < dump.currency.sql"
send_entry="$c <dump.entry.sql"
echo cleaning
eval $clean
echo sending currency
eval $send_currency
echo sending entry
eval $send_entry

