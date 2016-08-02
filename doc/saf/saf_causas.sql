##
ALTER TABLE saf_movimiento DROP CONSTRAINT fk_saf_movi_saf_causa_saf_caus;
ALTER TABLE saf_dt_movimiento DROP CONSTRAINT fk_saf_dt_m_saf_movim_saf_movi;
##
ALTER TABLE saf_causas ALTER COLUMN codcau TYPE integer USING codcau::integer;
ALTER TABLE saf_movimiento ALTER COLUMN codcau TYPE integer USING codcau::integer;
ALTER TABLE saf_dt_movimiento ALTER COLUMN codcau TYPE integer USING codcau::integer;
##
ALTER TABLE saf_movimiento ADD CONSTRAINT fk_saf_movi_saf_causa_saf_caus
FOREIGN KEY (codcau, estcat)
REFERENCES saf_causas(codcau, estcat) ON UPDATE RESTRICT ON DELETE RESTRICT;
#
ALTER TABLE saf_dt_movimiento ADD CONSTRAINT fk_saf_dt_m_saf_movim_saf_movi
FOREIGN KEY (codemp, cmpmov, codcau, estcat, feccmp)
REFERENCES saf_movimiento(codemp, cmpmov, codcau, estcat, feccmp) ON UPDATE RESTRICT ON DELETE RESTRICT;
## https://www.postgresql.org/docs/current/static/datatype-numeric.html#DATATYPE-SERIAL
CREATE SEQUENCE saf_causas_codcau_seq;
ALTER TABLE saf_causas ALTER COLUMN codcau SET DEFAULT nextval('saf_causas_codcau_seq');
#(Opcional: ERROR: sequence must have same owner as table it is linked to postgresql)
#ALTER TABLE saf_causas_codcau_seq OWNER TO postgres;
ALTER SEQUENCE saf_causas_codcau_seq OWNED BY saf_causas.codcau;

##
# SELECT nextval('saf_causas_codcau_seq');
# SELECT nextval(pg_get_serial_sequence('saf_causas', 'codcau'))
##


