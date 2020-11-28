SELECT PER_PERSONAL.PER_ID,
  PER_PERSONAL.PER_CARDNO,
  PER_PRENAME.PN_NAME,
  PER_PERSONAL.PER_NAME,
  PER_PERSONAL.PER_SURNAME,
  PER_PERSONAL.LEVEL_NO,
  PER_LEVEL.LEVEL_NAME,
  PER_PERSONAL.POEM_ID,
  PER_PERSONAL.PER_BIRTHDATE,
  PER_PERSONAL.PER_RETIREDATE,
   PER_PERSONAL.PER_STARTDATE,
  PER_PERSONAL.PER_SALARY,
  PER_PERSONAL.PER_TYPE,
  PER_PERSONAL.PER_STATUS,
  PER_PERSONAL.PER_STARTDATE AS PER_STARTDATE1,
   per_pos_emp.poem_id,
    per_pos_emp.poem_no,
    per_pos_emp.org_id,
    per_pos_emp.org_id_1,
    per_pos_emp.org_id_2,
    per_org.org_name,
    per_org1.org_name   AS org_name1,
    per_org2.org_name   AS org_name2,
    per_pos_emp.pn_code,
    per_pos_name.pn_name,
    per_pos_emp.poem_min_salary,
    per_pos_emp.poem_max_salary,
    per_pos_emp.department_id,
    per_pos_emp.poem_seq_no,
    per_pos_emp.poem_remark,
    per_pos_emp.pg_code_salary,
    per_pos_emp.poem_no_name,
    per_pos_emp.poem_status,
    per_pos_emp.update_user,
    per_pos_emp.update_date,
    (per_personalpic.per_cardno || '-' || LPAD(per_personalpic.per_picseq,3,'0')  || '.jpg') as per_picture,
FROM PER_PERSONAL
LEFT JOIN PER_PRENAME
ON PER_PRENAME.PN_CODE = PER_PERSONAL.PN_CODE
LEFT JOIN PER_LEVEL
ON PER_LEVEL.LEVEL_NO = PER_PERSONAL.LEVEL_NO
    LEFT JOIN per_pos_emp ON per_pos_emp.POEM_ID = PER_PERSONAL.POEM_ID
    left JOIN per_org ON per_pos_emp.org_id = per_org.org_id
    LEFT JOIN per_org per_org1 ON per_pos_emp.org_id_1 = per_org1.org_id
    LEFT JOIN per_org per_org2 ON per_pos_emp.org_id_2 = per_org2.org_id
    LEFT JOIN per_pos_name ON per_pos_name.pn_code = per_pos_emp.pn_code
    LEFT JOIN per_personalpic ON per_personal.per_id = per_personalpic.per_id AND per_personalpic.pic_show = 1
WHERE PER_PERSONAL.PER_TYPE = 2
AND PER_PERSONAL.PER_STATUS = 1