/************************************************************
 *
 * Procedimiento de cambio del prefijo de la base de datos
 *
 ***********************************************************/
;

/* 1) Renombrar tablas con el administrador de la BD. */
;

RENAME TABLE wp_links TO xxxx_links;

RENAME TABLE wp_commentmeta TO xxxx_commentmeta;

RENAME TABLE wp_comments TO xxxx_comments;

RENAME TABLE wp_options TO xxxx_options;

RENAME TABLE wp_postmeta TO xxxx_postmeta;

RENAME TABLE wp_posts TO xxxx_posts;

RENAME TABLE wp_term_relationships TO xxxx_term_relationships;

RENAME TABLE wp_term_taxonomy TO xxxx_term_taxonomy;

RENAME TABLE wp_termmeta TO xxxx_termmeta;

RENAME TABLE wp_terms TO xxxx_terms;

RENAME TABLE wp_usermeta TO xxxx_usermeta;

RENAME TABLE wp_users TO xxxx_users;

/* 2) actualizar la tabla usermeta. */
;

UPDATE
   xxxx_usermeta
SET
   meta_key = REPLACE(meta_key, 'wp_', 'xxxx_')
WHERE
   SUBSTRING(meta_key, 1, 3) = 'wp_';

/* 3) actualizar la tabla de opciones. */
;

UPDATE
   xxxx_options
SET
   option_name = REPLACE(option_name, 'wp_', 'xxxx_')
WHERE
   SUBSTRING(option_name, 1, 3) = 'wp_';

/* 4) COMPROBAR REGISTROS: */
;

SELECT
   *
FROM
   xxxx_options
WHERE
   SUBSTRING(option_name, 1, 3) = 'wp_';

SELECT
   *
FROM
   xxxx_usermeta
WHERE
   SUBSTRING(meta_key, 1, 3) = 'wp_';

/* 5) Modificar la variable table_prefix en wp_config.php*/
/***********************************************************/
;

SELECT
   t1.meta_value AS comite_id,
   CASE
      WHEN t2.meta_value < '2022-11-01'
      AND t3.meta_value = '1' then 1
      WHEN t2.meta_value BETWEEN '2022-11-01'
      AND '2022-11-30'
      AND t3.meta_value = '1' then 2
      WHEN t2.meta_value > '2022-11-30'
      AND t3.meta_value = '1' then 3
      ELSE 4
   END AS etiqueta,
   t4.meta_value AS asignado,
   count(ID) as total
FROM
   wp_posts
   INNER JOIN wp_postmeta AS t1 ON (ID = t1.post_id)
   INNER JOIN wp_postmeta AS t2 ON (ID = t2.post_id)
   INNER JOIN wp_postmeta AS t3 ON (ID = t3.post_id)
   INNER JOIN wp_postmeta AS t4 ON (ID = t4.post_id)
WHERE
   1 = 1
   AND (
      (
         t1.meta_key = '_comite_id'
         AND t1.meta_value != ''
      )
      AND (
         t2.meta_key = '_f_compromiso'
         AND t2.meta_value != ''
      )
      AND (
         t3.meta_key = '_vigente'
         AND t3.meta_value != ''
      )
      AND (
         t4.meta_key = '_asignar_a'
         AND t4.meta_value != ''
      )
   )
   AND (
      (
         wp_posts.post_type = 'acuerdo'
         AND (
            wp_posts.post_status = 'publish'
            OR wp_posts.post_status = 'private'
         )
      )
   )
GROUP BY
   t1.meta_value,
   CASE
      WHEN t2.meta_value < '2022-11-01'
      AND t3.meta_value = '1' then 1
      WHEN t2.meta_value BETWEEN '2022-11-01'
      AND '2022-11-30'
      AND t3.meta_value = '1' then 2
      WHEN t2.meta_value > '2022-11-30'
      AND t3.meta_value = '1' then 3
      ELSE 4
   END,
   t4.meta_value
ORDER BY
   t1.meta_value,
   CASE
      WHEN t2.meta_value < '2022-11-01'
      AND t3.meta_value = '1' then 1
      WHEN t2.meta_value BETWEEN '2022-11-01'
      AND '2022-11-30'
      AND t3.meta_value = '1' then 2
      WHEN t2.meta_value > '2022-11-30'
      AND t3.meta_value = '1' then 3
      ELSE 4
   END,
   t4.meta_value;

/**************************** Versión 2 **************************************/
SELECT
   t4.meta_value AS asignado,
   t1.meta_value AS comite_id,
   t3.meta_value AS vigencia,
   CASE
      WHEN t2.meta_value < '2023-07-01' then 1
      WHEN t2.meta_value BETWEEN '2023-07-01'
      AND '2023-07-31' then 2
      WHEN t2.meta_value > '2023-07-31' then 3
   END AS etiqueta,
   count(ID) as total
FROM
   wp_posts
   INNER JOIN wp_postmeta AS t1 ON (ID = t1.post_id)
   INNER JOIN wp_postmeta AS t2 ON (ID = t2.post_id)
   INNER JOIN wp_postmeta AS t3 ON (ID = t3.post_id)
   INNER JOIN wp_postmeta AS t4 ON (ID = t4.post_id)
WHERE
   1 = 1
   AND (
      (
         t1.meta_key = '_comite_id'
         AND t1.meta_value != ''
      )
      AND (
         t2.meta_key = '_f_compromiso'
         AND t2.meta_value != ''
      )
      AND (
         t3.meta_key = '_vigente'
         AND t3.meta_value != ''
      )
      AND (
         t4.meta_key = '_asignar_id'
         AND t4.meta_value != ''
      )
   )
   AND (
      (
         wp_posts.post_type = 'acuerdo'
         AND (
            wp_posts.post_status = 'publish'
            OR wp_posts.post_status = 'private'
         )
      )
   )
GROUP BY
   t4.meta_value,
   t1.meta_value,
   t3.meta_value,
   CASE
      WHEN t2.meta_value < '2023-07-01' then 1
      WHEN t2.meta_value BETWEEN '2023-07-01'
      AND '2023-07-31' then 2
      WHEN t2.meta_value > '2023-07-31' then 3
   END
ORDER BY
   t4.meta_value,
   t1.meta_value,
   t3.meta_value,
   CASE
      WHEN t2.meta_value < '2023-07-01' then 1
      WHEN t2.meta_value BETWEEN '2023-07-01'
      AND '2023-07-31' then 2
      WHEN t2.meta_value > '2023-07-31' then 3
   END;

/****************** NUMERO DE ACUERDOS POR COMITE Y POR ACTA ******************/
SELECT
   t01.meta_value AS 'comite_id',
   count(t03.meta_value) AS 'totalActas',
FROM
   wp_posts
   INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
   INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
   INNER JOIN wp_postmeta t03 ON (ID = t03.post_id)
WHERE
   1 = 1
   AND(
      (
         t01.meta_key = '_n_acuerdo'
         AND t01.meta_value != ''
      )
      AND (
         t02.meta_key = '_comite_id'
         AND t02.meta_value = '" . $comite_id . "'
      )
      AND (
         t03.meta_key = '_acta_id'
         AND t03.meta_value = '" . $acta_id . "'
      )
   )
   AND post_type = 'acuerdo'
   AND post_status = 'publish';