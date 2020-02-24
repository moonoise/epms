
-- //รายงานคนที่ ทำเสร็จแล้ว


select per_personal_2019_2.per_cardno , CONCAT(per_personal_2019_2.per_name," ",per_personal_2019_2.per_surname),org0.org_name,org1.org_name   FROM per_personal_2019_2 
LEFT JOIN per_org org0 ON org0.org_id = per_personal_2019_2.org_id
LEFT JOIN per_org org1 ON org1.org_id = per_personal_2019_2.org_id_1
RIGHT JOIN cpc_score_result_2019_2 ON cpc_score_result_2019_2.per_cardno = per_personal_2019_2.per_cardno
		
RIGHT JOIN kpi_score_result_2019_2 ON kpi_score_result_2019_2.per_cardno = per_personal_2019_2.per_cardno
	
WHERE cpc_score_result_2019_2.cpc_score_result_head IS NOT null  AND kpi_score_result_2019_2.kpi_score_result IS NOT null



-- รายงานคนที่ ยังทำไม่เสร็จ

select per_personal_2019_2.per_cardno , CONCAT(per_personal_2019_2.per_name," ",per_personal_2019_2.per_surname),org0.org_name,org1.org_name   FROM per_personal_2019_2 
LEFT JOIN per_org org0 ON org0.org_id = per_personal_2019_2.org_id
LEFT JOIN per_org org1 ON org1.org_id = per_personal_2019_2.org_id_1
RIGHT JOIN cpc_score_result_2019_2 ON cpc_score_result_2019_2.per_cardno = per_personal_2019_2.per_cardno
		
RIGHT JOIN kpi_score_result_2019_2 ON kpi_score_result_2019_2.per_cardno = per_personal_2019_2.per_cardno
	
WHERE cpc_score_result_2019_2.cpc_score_result_head IS  null  AND kpi_score_result_2019_2.kpi_score_result IS  null