-- Execute somente depois de verificar emails repetidos:
-- SELECT emai_nome, COUNT(*) FROM email GROUP BY emai_nome HAVING COUNT(*) > 1;
ALTER TABLE email ADD UNIQUE KEY uq_email_nome (emai_nome);
