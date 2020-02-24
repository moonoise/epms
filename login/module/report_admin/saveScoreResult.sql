DROP PROCEDURE IF EXISTS saveScoreResult;
delimiter $$
create procedure saveScoreResult(IN `pPer_cardno` VARCHAR(20), IN `pYears` VARCHAR(10), IN `pCpc_score_result_table` VARCHAR(30), IN `pCpc_score_result_head` INT(5), IN `pScoring` INT(5))
begin
SET @pCpc_score_result_table = pCpc_score_result_table;
  IF EXISTS (SELECT * FROM @pCpc_score_result_table WHERE `per_cardno` = pPer_cardno AND `years` = pYears ) THEN
                        UPDATE @pCpc_score_result_table SET `cpc_score_result_head` = pCpc_score_result_head , `scoring` = pScoring   WHERE `per_cardno` = pPer_cardno AND `years` = pYears ;
                    ELSE 
                        INSERT INTO @pCpc_score_result_table (`per_cardno`,`cpc_score_result_head`,`scoring`,`years`) VALUES (pPer_cardno,pCpc_score_result_head,pScoring,pYears) ;  
                    END IF ;
end $$
delimiter ;



