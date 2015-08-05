-- liste des articles
SELECT distinct tag
FROM wikini_pages
where user not in ( 'WikiNiInstaller', 'WikiAdmin' )
order by tag
;


-- liste des articles avec toutes leurs révisions
SELECT *
FROM `wikini_pages`
where user not in ( 'WikiNiInstaller', 'WikiAdmin' )
order by tag asc, time desc
;


-- nb de revisions des articles
SELECT tag, count( * ) AS nb
FROM wikini_pages
where user not in ( 'WikiNiInstaller', 'WikiAdmin' )
GROUP BY tag
having nb > 1
order by nb DESC
;


-- dernière revision de chaque article
select *
from wikini_pages
where (tag, time) in
(
SELECT tag, max(time)
FROM wikini_pages
where 
GROUP BY tag
-- having count(*) > 1 -- seulement ceux qui ont plusieurs versions ?
)
order by tag
;
