pg_dump --data-only -Fp --table=currency -Ufey cuvie > dump.sql
pg_dump --data-only -Fp --table=entry -Ufey cuvie >> dump.sql
