pg_dump --data-only -Fp --table=currency -Ufey cuvie > dump.currency.sql
pg_dump --data-only -Fp --table=entry -Ufey cuvie >> dump.entry.sql
