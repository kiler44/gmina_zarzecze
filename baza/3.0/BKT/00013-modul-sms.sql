-- DROP TABLE modul_sms;

CREATE TABLE modul_sms
(
	id integer NOT NULL,  
	id_projektu integer NOT NULL,  
   id_sms_reference integer,
	object character varying(80),  
   id_object integer,
   date_sent timestamp without time zone NOT NULL DEFAULT now(),
   date_delivered timestamp without time zone,
	id_sender integer,  
	id_recipient integer,  
	sender_number character varying(14) NOT NULL,  
	recipient_number character varying(14) NOT NULL,  
	message text NOT NULL,
	status_info character varying(400),  
	sent boolean NOT NULL,  
	type character varying(60),  
   require_send boolean,
	CONSTRAINT modul_sms_pkey PRIMARY KEY (id, id_projektu)
)
WITH (
  OIDS=FALSE
);