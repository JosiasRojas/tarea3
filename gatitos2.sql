PGDMP     "                    y            gatitos2    12.6    12.6                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    16845    gatitos2    DATABASE     ?   CREATE DATABASE gatitos2 WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Spain.1252' LC_CTYPE = 'Spanish_Spain.1252';
    DROP DATABASE gatitos2;
                postgres    false            ?            1259    16867 	   billetera    TABLE     ?   CREATE TABLE public.billetera (
    codigo character varying NOT NULL,
    id_usuario integer NOT NULL,
    cantidad double precision,
    CONSTRAINT billetera_cantidad_check CHECK ((cantidad > (0)::double precision))
);
    DROP TABLE public.billetera;
       public         heap    postgres    false            ?            1259    16862    moneda    TABLE     ?   CREATE TABLE public.moneda (
    cod character varying(5) NOT NULL,
    nombre character varying(25) NOT NULL,
    valor_actual double precision NOT NULL
);
    DROP TABLE public.moneda;
       public         heap    postgres    false            ?            1259    16848    usuario    TABLE     ?  CREATE TABLE public.usuario (
    id_usuario integer NOT NULL,
    nombre character varying(25) NOT NULL,
    apellido character varying(25) NOT NULL,
    correo character varying(320) NOT NULL,
    contra character varying(100) NOT NULL,
    pais character varying(45),
    is_admin boolean DEFAULT false,
    fecha_ingreso date DEFAULT CURRENT_DATE,
    CONSTRAINT usuario_pais_check CHECK (((pais)::text = ANY ((ARRAY['Angola'::character varying, 'Suiza'::character varying, 'Sudáfrica'::character varying, 'Canada'::character varying, 'Estados Unidos'::character varying, 'Chile'::character varying, 'Australia'::character varying, 'India'::character varying, 'Corea del Sur'::character varying, 'Rusia'::character varying])::text[])))
);
    DROP TABLE public.usuario;
       public         heap    postgres    false            ?            1259    16846    usuario_id_usuario_seq    SEQUENCE     ?   CREATE SEQUENCE public.usuario_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.usuario_id_usuario_seq;
       public          postgres    false    203                        0    0    usuario_id_usuario_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.usuario_id_usuario_seq OWNED BY public.usuario.id_usuario;
          public          postgres    false    202            ?
           2604    16851    usuario id_usuario    DEFAULT     x   ALTER TABLE ONLY public.usuario ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuario_id_usuario_seq'::regclass);
 A   ALTER TABLE public.usuario ALTER COLUMN id_usuario DROP DEFAULT;
       public          postgres    false    202    203    203                      0    16867 	   billetera 
   TABLE DATA           A   COPY public.billetera (codigo, id_usuario, cantidad) FROM stdin;
    public          postgres    false    205   ?                 0    16862    moneda 
   TABLE DATA           ;   COPY public.moneda (cod, nombre, valor_actual) FROM stdin;
    public          postgres    false    204   ?                 0    16848    usuario 
   TABLE DATA           n   COPY public.usuario (id_usuario, nombre, apellido, correo, contra, pais, is_admin, fecha_ingreso) FROM stdin;
    public          postgres    false    203   ?       !           0    0    usuario_id_usuario_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.usuario_id_usuario_seq', 5, true);
          public          postgres    false    202            ?
           2606    16875    billetera billetera_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.billetera
    ADD CONSTRAINT billetera_pkey PRIMARY KEY (codigo, id_usuario);
 B   ALTER TABLE ONLY public.billetera DROP CONSTRAINT billetera_pkey;
       public            postgres    false    205    205            ?
           2606    16866    moneda moneda_pkey 
   CONSTRAINT     Q   ALTER TABLE ONLY public.moneda
    ADD CONSTRAINT moneda_pkey PRIMARY KEY (cod);
 <   ALTER TABLE ONLY public.moneda DROP CONSTRAINT moneda_pkey;
       public            postgres    false    204            ?
           2606    16861    usuario usuario_correo_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_correo_key UNIQUE (correo);
 D   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_correo_key;
       public            postgres    false    203            ?
           2606    16859    usuario usuario_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id_usuario);
 >   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pkey;
       public            postgres    false    203            ?
           2606    16876    billetera billetera_codigo_fkey    FK CONSTRAINT        ALTER TABLE ONLY public.billetera
    ADD CONSTRAINT billetera_codigo_fkey FOREIGN KEY (codigo) REFERENCES public.moneda(cod);
 I   ALTER TABLE ONLY public.billetera DROP CONSTRAINT billetera_codigo_fkey;
       public          postgres    false    204    2707    205            ?
           2606    16881    billetera id_usuario    FK CONSTRAINT     ?   ALTER TABLE ONLY public.billetera
    ADD CONSTRAINT id_usuario FOREIGN KEY (id_usuario) REFERENCES public.usuario(id_usuario) ON DELETE CASCADE;
 >   ALTER TABLE ONLY public.billetera DROP CONSTRAINT id_usuario;
       public          postgres    false    205    203    2705                  x?
?4?423?
? 2????b???? 1??         .   x?
???Q???	?42?
??O,Rp????41?????? ??           x?]?AR?0 ?uz
l	M*???`??,???ICBS?	???,^̎?3?????y????Iq"?i ?jĀ?DHH?????p{???.??(?(????!Gu??????P?|??|E<C?^10?#?-???(?lcԱ?B)??vT???????%??W?Bv+?mEu?-?????$?^>?#?k??.,??~?Z?rS???_?id%?&;???s?6?J]?K?G???A????a9?L??^?K??pg|??mW]?/^m?bb???ȕ????WhY?!?p?     