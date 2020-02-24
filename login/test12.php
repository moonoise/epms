SELECT `cpc_score`.`cpc_score_id`,
       `cpc_score`.`question_no`,
       `cpc_score`.`per_cardno`,
     ( CASE  `cpc_score`.`cpc_divisor`
      WHEN   1 THEN ( `cpc_score`.`cpc_accept1`) 
      WHEN   2 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2`)/2) 
      WHEN   3 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3`)/3) 
      WHEN   4 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3` + `cpc_score`.`cpc_accept4`)/4) 
      WHEN   5 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3` + `cpc_score`.`cpc_accept4` + `cpc_score`.`cpc_accept5`)/5) 
      ELSE NULL
      END  ) as result,
      `cpc_question`.`question_code`,
      `cpc_question`.`question_title`
	
FROM `cpc_score` 
LEFT JOIN `cpc_question` ON `cpc_question`.`question_no` = `cpc_score`.`question_no`
WHERE per_cardno = '1189800031101' AND cpc_score_id = 2338



SELECT `cpc_score`.`cpc_score_id`,
       `cpc_score`.`question_no`,
       `cpc_score`.`per_cardno`,
     ( CASE  `cpc_score`.`cpc_divisor`
      WHEN   1 THEN ( `cpc_score`.`cpc_accept1`) 
      WHEN   2 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2`)/2) 
      WHEN   3 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3`)/3) 
      WHEN   4 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3` + `cpc_score`.`cpc_accept4`)/4) 
      WHEN   5 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3` + `cpc_score`.`cpc_accept4` + `cpc_score`.`cpc_accept5`)/5) 
      ELSE NULL
      END  ) as result,
      `cpc_question`.`question_code`,
      `cpc_question`.`question_title`,
      `cpc_question`.`question_type`,
      `per_personal_2561`.`level_no`
      (if (`per_personal_2561`.`level_no` = 'D1' OR `per_personal_2561`.`level_no` = 'D2') THEN 
       		(if (`cpc_question`.`question_type` = 1) THEN 10 
             ELSEIF (`cpc_question`.`question_type` = 2) THEN 4
             ELSEIF (`cpc_question`.`question_type` = 3) THEN 3
             )
		ELSE 10
      ) AS `cpc_weigth`
FROM `cpc_score` 
LEFT JOIN `cpc_question` ON `cpc_question`.`question_no` = `cpc_score`.`question_no`
	AND (`cpc_question`.`question_type` = 1 OR `cpc_question`.`question_type` = 2 OR `cpc_question`.`question_type` = 3 )
LEFT JOIN `per_personal_2561` ON `per_personal_2561`.`per_cardno` = `cpc_score`.`per_cardno`
WHERE per_cardno = '1189800031101' AND cpc_score_id = 2338





SELECT `cpc_score`.`cpc_score_id`,
       `cpc_score`.`question_no`,
       `cpc_score`.`per_cardno`,
     ( CASE  `cpc_score`.`cpc_divisor`
      WHEN   1 THEN ( `cpc_score`.`cpc_accept1`) 
      WHEN   2 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2`)/2) 
      WHEN   3 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3`)/3) 
      WHEN   4 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3` + `cpc_score`.`cpc_accept4`)/4) 
      WHEN   5 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3` + `cpc_score`.`cpc_accept4` + `cpc_score`.`cpc_accept5`)/5) 
      ELSE NULL
      END  ) as result,
      `cpc_question`.`question_code`,
      `cpc_question`.`question_title`,
      `cpc_question`.`question_type`,
      `per_personal_2561`.`level_no`,
      IF (`per_personal_2561`.`level_no` = 'D1' OR `per_personal_2561`.`level_no` = 'D2' ,  
         ( CASE `cpc_question`.`question_type`
          	WHEN 1 THEN 10
          	WHEN 2 THEN 4
          	WHEN 3 THEN 3
          END
          )
          , 10) AS cpc_weight
FROM `cpc_score` 
LEFT JOIN `cpc_question` ON `cpc_question`.`question_no` = `cpc_score`.`question_no`
	AND (`cpc_question`.`question_type` = 1 OR `cpc_question`.`question_type` = 2 OR `cpc_question`.`question_type` = 3 )
LEFT JOIN `per_personal_2561` ON `per_personal_2561`.`per_cardno` = `cpc_score`.`per_cardno`
WHERE `cpc_score`.`per_cardno` = '1189800031101'





SELECT `cpc_score`.`cpc_score_id`,
       `cpc_score`.`question_no`,
       `cpc_score`.`per_cardno`,
     ( CASE  `cpc_score`.`cpc_divisor`
      WHEN   1 THEN ( `cpc_score`.`cpc_accept1`) 
      WHEN   2 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2`)/2) 
      WHEN   3 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3`)/3) 
      WHEN   4 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3` + `cpc_score`.`cpc_accept4`)/4) 
      WHEN   5 THEN ( (`cpc_score`.`cpc_accept1` + `cpc_score`.`cpc_accept2` +`cpc_score`.`cpc_accept3` + `cpc_score`.`cpc_accept4` + `cpc_score`.`cpc_accept5`)/5) 
      ELSE NULL
      END  ) as result,
      `cpc_question`.`question_code`,
      `cpc_question`.`question_title`,
      `cpc_question`.`question_type`,
      `per_personal_2561`.`level_no`,
      IF (`per_personal_2561`.`level_no` = 'D1' OR `per_personal_2561`.`level_no` = 'D2' ,  
         ( CASE `cpc_question`.`question_type`
          	WHEN 1 THEN 10
          	WHEN 2 THEN 4
          	WHEN 3 THEN 3
          END
          )
          , 10) AS cpc_weight
FROM `cpc_score` 
INNER JOIN `cpc_question` ON (`cpc_question`.`question_no` = `cpc_score`.`question_no` )
	AND (`cpc_question`.`question_type` = 1 OR `cpc_question`.`question_type` = 2 OR `cpc_question`.`question_type` = 3 )
LEFT JOIN `per_personal_2561` ON `per_personal_2561`.`per_cardno` = `cpc_score`.`per_cardno`
WHERE `cpc_score`.`per_cardno` = '1189800031101'
ORDER BY `cpc_question`.`question_code` ASC