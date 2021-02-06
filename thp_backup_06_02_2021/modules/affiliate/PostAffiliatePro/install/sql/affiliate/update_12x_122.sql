alter table pa_affiliates add payableto VARCHAR(100);
alter table pa_campaigncategories add strecurringcommission FLOAT;
alter table pa_campaigncategories add strecurringcommtype VARCHAR(5);
alter table pa_recurringcommissions add stcommission FLOAT;
alter table pa_recurringcommissions add stcommtype VARCHAR(5);
alter table pa_recurringcommissions add staffiliateid bigint;

