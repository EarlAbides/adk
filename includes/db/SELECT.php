<?php
	
	// Applicant
	function sql_checkApplicantAndUsernameNotExists($con, $ADK_APPLICANT_USERNAME, $exempt) {
        $sql_query = $con->prepare(
            "SELECT
				(SELECT COUNT(*) FROM ADK_USER WHERE ADK_USER_USERNAME = ? AND ADK_USER_USERNAME <> ?) +
				(SELECT COUNT(*) FROM ADK_APPLICANT WHERE ADK_APPLICANT_USERNAME = ? AND ADK_APPLICANT_USERNAME <> ?)
			AS COUNT;"
        );
		
        $sql_query->bind_param('ssss', $ADK_APPLICANT_USERNAME, $exempt, $ADK_APPLICANT_USERNAME, $exempt);
		
        return $sql_query;
	}
	
	function sql_getApplicants($con) {
		$sql_query = $con->prepare(
			"SELECT ADK_APPLICANT_ID, ADK_APPLICANT_USERNAME, ADK_APPLICANT_NAME, ADK_APPLICANT_EMAIL, ADK_APPLICANT_PHONE
				, ADK_APPLICANT_STATE, ADK_APPLICANT_DTE
			FROM ADK_APPLICANT;"
		);

		return $sql_query;
	}
	
	function sql_getApplicant($con, $ADK_APPLICANT_ID) {
		$sql_query = $con->prepare(
			"SELECT A.ADK_APPLICANT_ID, A.ADK_APPLICANT_USERNAME, A.ADK_APPLICANT_NAME, A.ADK_APPLICANT_EMAIL, A.ADK_APPLICANT_PHONE
				, A.ADK_APPLICANT_AGE, A.ADK_APPLICANT_SEX, A.ADK_APPLICANT_ADDRESS1, A.ADK_APPLICANT_ADDRESS2
				, A.ADK_APPLICANT_CITY, A.ADK_APPLICANT_STATE, A.ADK_APPLICANT_ZIP, A.ADK_APPLICANT_COUNTRY
				, A.ADK_APPLICANT_PERSONALINFO, A.ADK_APPLICANT_REQ_CORR
				, (SELECT GROUP_CONCAT(' ', P.ADK_PEAK_NAME) FROM ADK_PEAK P WHERE P.ADK_PEAK_ID IN(
					SELECT AP.ADK_PEAK_ID FROM ADK_APPLICANT_PEAK_JCT AP
					WHERE AP.ADK_APPLICANT_ID = A.ADK_APPLICANT_ID
                )) ADK_APPLICANT_PEAKLIST				
			FROM ADK_APPLICANT A
			WHERE ADK_APPLICANT_ID = ?;"
		);
		
		$sql_query->bind_param('i', $ADK_APPLICANT_ID);

		return $sql_query;
	}
	
	function sql_getApplicantsPeaks($con, $ADK_APPLICANT_ID) {
		$sql_query = $con->prepare(
            "SELECT P.ADK_PEAK_ID, P.ADK_PEAK_NAME, P.ADK_PEAK_HEIGHT
			FROM ADK_PEAK P
				LEFT JOIN ADK_APPLICANT_PEAK_JCT AP ON P.ADK_PEAK_ID = AP.ADK_PEAK_ID
			WHERE AP.ADK_APPLICANT_ID = ?;"
        );

        $sql_query->bind_param('i', $ADK_APPLICANT_ID);

        return $sql_query;
	}
	
	// Correspondent
	function sql_getCorrespondents($con) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_USER_ID, B.ADK_USER_USERNAME, B.ADK_USER_NAME, B.ADK_USER_EMAIL, A.ADK_CORR_PHOTO_ID
				, A.ADK_CORR_PERSONALINFO, ADK_CORR_DTE
				, (SELECT COUNT(*) FROM ADK_HIKER C WHERE A.ADK_USER_ID = C.ADK_HIKER_CORR_ID) AS ADK_CORR_NUMHIKERS
			FROM ADK_CORRESPONDENT A
				LEFT JOIN ADK_USER B ON A.ADK_USER_ID = B.ADK_USER_ID;"
        );

        return $sql_query;
	}
	
	function sql_getCorrespondent($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_USER_ID, B.ADK_USER_USERNAME, B.ADK_USER_NAME, B.ADK_USER_EMAIL, A.ADK_CORR_PHOTO_ID
				, A.ADK_CORR_PERSONALINFO
				, (SELECT COUNT(*) FROM ADK_HIKER C WHERE A.ADK_USER_ID = C.ADK_HIKER_CORR_ID) AS ADK_CORR_NUMHIKERS
			FROM ADK_CORRESPONDENT A
				LEFT JOIN ADK_USER B ON A.ADK_USER_ID = B.ADK_USER_ID
			WHERE A.ADK_USER_ID = ?;"
        );

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}
	
	function sql_getMatchingCorrespondents($con, $term) {
        $term = '%'.$term.'%';
        
		$sql_query = $con->prepare(
            "SELECT CONCAT(B.ADK_USER_NAME, ' (', B.ADK_USER_USERNAME, ')') AS ADK_CORRESPONDENT
			FROM ADK_CORRESPONDENT A
				LEFT JOIN ADK_USER B ON A.ADK_USER_ID = B.ADK_USER_ID
			WHERE B.ADK_USER_NAME LIKE ?
				OR B.ADK_USER_USERNAME LIKE ?;"
        );

        $sql_query->bind_param('ss', $term, $term);

        return $sql_query;
	}
	
	// File
    function sql_getFile($con, $ADK_FILE_ID) {
		$sql_query = $con->prepare(
            "SELECT ADK_FILE_ID, ADK_FILE_NAME, ADK_FILE_SAVENAME, ADK_FILE_SIZE, ADK_FILE_TYPE
			FROM ADK_FILE WHERE ADK_FILE_ID = ?;"
        );

        $sql_query->bind_param('i', $ADK_FILE_ID);

        return $sql_query;
	}
	
	function sql_getFileGallery($con, $ADK_USER_ID, $ADK_CORR_ID) {
        $sql_query = $con->prepare(
            "SELECT F.ADK_FILE_ID, F.ADK_FILE_NAME, F.ADK_FILE_SAVENAME, F.ADK_FILE_DESC, F.ADK_FILE_SIZE, F.ADK_FILE_TYPE, U.ADK_USER_USERNAME
                , (SELECT GROUP_CONCAT(P.ADK_PEAK_NAME) FROM ADK_PEAK P
		            LEFT JOIN ADK_HIKE_PEAK_JCT HP ON P.ADK_PEAK_ID = HP.ADK_PEAK_ID
                    LEFT JOIN ADK_HIKE H2 ON HP.ADK_HIKE_ID = H2.ADK_HIKE_ID
	            WHERE H2.ADK_HIKE_ID = H.ADK_HIKE_ID) AS ADK_FILE_PEAKS
			FROM ADK_FILE F
                LEFT JOIN ADK_HIKE_FILE_JCT HF ON F.ADK_FILE_ID = HF.ADK_FILE_ID
                LEFT JOIN ADK_HIKE H ON HF.ADK_HIKE_ID = H.ADK_HIKE_ID
                LEFT JOIN ADK_MESSAGE_FILE_JCT MF ON F.ADK_FILE_ID = MF.ADK_FILE_ID
                LEFT JOIN ADK_MESSAGE M ON MF.ADK_MESSAGE_ID = M.ADK_MESSAGE_ID
				LEFT JOIN ADK_USER U ON H.ADK_USER_ID = U.ADK_USER_ID OR M.ADK_MESSAGE_FROM_USER_ID = U.ADK_USER_ID
            WHERE (H.ADK_USER_ID LIKE ?
                OR M.ADK_MESSAGE_FROM_USER_ID LIKE ?)
				AND U.ADK_USER_ID IN(SELECT H.ADK_USER_ID FROM ADK_HIKER H WHERE ADK_HIKER_CORR_ID LIKE ?)
            ORDER BY ADK_FILE_ID DESC;"
        );

        $sql_query->bind_param('sss', $ADK_USER_ID, $ADK_USER_ID, $ADK_CORR_ID);

        return $sql_query;
    }
	
	// Hike
	function sql_getHikes($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_HIKE_ID, A.ADK_HIKE_NOTES, A.ADK_HIKE_DTE, ADK_HIKE_TS
				, (SELECT COUNT(*) FROM ADK_HIKE_PEAK_JCT B
					WHERE B.ADK_HIKE_ID = A.ADK_HIKE_ID) ADK_HIKE_NUMPEAKS
			FROM ADK_HIKE A
			WHERE A.ADK_USER_ID = ?;"
        );

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}
	function sql_getHikesPeaks($con, $ADK_HIKE_ID) {
		$sql_query = $con->prepare(
            "SELECT P.ADK_PEAK_ID, P.ADK_PEAK_NAME, P.ADK_PEAK_HEIGHT, HP.ADK_PEAK_DTE
			FROM ADK_PEAK P
				LEFT JOIN ADK_HIKE_PEAK_JCT HP ON P.ADK_PEAK_ID = HP.ADK_PEAK_ID
			WHERE HP.ADK_HIKE_ID = ?;"
        );

        $sql_query->bind_param('i', $ADK_HIKE_ID);

        return $sql_query;
	}
	function sql_getHikesFiles($con, $ADK_HIKE_ID) {
		$sql_query = $con->prepare(
            "SELECT F.ADK_FILE_ID, F.ADK_FILE_NAME, F.ADK_FILE_DESC, F.ADK_FILE_SIZE, F.ADK_FILE_TYPE
			FROM ADK_FILE F
				LEFT JOIN ADK_HIKE_FILE_JCT HF ON F.ADK_FILE_ID = HF.ADK_FILE_ID
			WHERE HF.ADK_HIKE_ID = ?
			ORDER BY F.ADK_FILE_NAME;"
        );
        
        $sql_query->bind_param('i', $ADK_HIKE_ID);

        return $sql_query;
	}

	function sql_getHikersPeaks($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT P.ADK_PEAK_NAME, DATE_FORMAT(H.ADK_HIKE_DTE, '%m/%d/%Y') ADK_HIKE_DTE
			FROM ADK_PEAK P
				LEFT JOIN ADK_HIKE_PEAK_JCT HP ON P.ADK_PEAK_ID = HP.ADK_PEAK_ID
				LEFT JOIN ADK_HIKE H ON HP.ADK_HIKE_ID = H.ADK_HIKE_ID
			WHERE H.ADK_USER_ID = ?;"
        );

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}

	function sql_checkHasClimbed($con, $ADK_USER_ID, $ADK_PEAK_IDS, $ADK_HIKE_ID) {
		$sql_query = $con->prepare(
			"SELECT COUNT(*) FROM ADK_HIKE_PEAK_JCT
			WHERE ADK_PEAK_ID IN(?)
				AND ADK_HIKE_ID IN(SELECT ADK_HIKE_ID FROM ADK_HIKE WHERE ADK_USER_ID = ?)
				AND ADK_HIKE_ID NOT IN(?);"
        );
		
		for($i = 0; $i < count($ADK_PEAK_IDS); $i++) $ADK_PEAK_IDS[$i] = "'".$ADK_PEAK_IDS[$i]."'";
		$ADK_PEAK_IDS = implode(',', $ADK_PEAK_IDS);
		$ADK_HIKE_ID = isset($ADK_HIKE_ID)? $ADK_HIKE_ID: '';

        $sql_query->bind_param('sis', $ADK_PEAK_IDS, $ADK_USER_ID, $ADK_HIKE_ID);
		
        return $sql_query;
	}
	
	// Hiker
	function sql_getHikers($con, $ADK_HIKER_CORR_ID) {
		$sql_query = $con->prepare(
            "SELECT H.ADK_USER_ID, U.ADK_USER_USERNAME, U.ADK_USER_NAME, U.ADK_USER_EMAIL, H.ADK_HIKER_CORR_ID, H.ADK_HIKER_LASTACTIVE_DTE, H.ADK_HIKER_DTE
				, (SELECT CONCAT(U.ADK_USER_NAME, ' (', U.ADK_USER_USERNAME, ')') FROM ADK_USER U
					WHERE H.ADK_HIKER_CORR_ID = U.ADK_USER_ID) ADK_HIKER_CORR_NAME
				, (SELECT COUNT(DISTINCT ADK_PEAK_ID) FROM ADK_HIKE_PEAK_JCT HP
					LEFT JOIN ADK_HIKE HI ON HP.ADK_HIKE_ID = HI.ADK_HIKE_ID
				WHERE HI.ADK_USER_ID = H.ADK_USER_ID) ADK_HIKER_NUMPEAKS
			FROM ADK_HIKER H
				LEFT JOIN ADK_USER U ON H.ADK_USER_ID = U.ADK_USER_ID
			WHERE H.ADK_HIKER_CORR_ID LIKE ?;"
        );

        $sql_query->bind_param('s', $ADK_HIKER_CORR_ID);

        return $sql_query;
	}
	
	function sql_getHiker($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT H.ADK_USER_ID, H.ADK_HIKER_CORR_ID, H.ADK_HIKER_PHOTO_ID, U.ADK_USER_USERNAME, U.ADK_USER_NAME, U.ADK_USER_EMAIL, H.ADK_HIKER_PHONE
				, H.ADK_HIKER_AGE, H.ADK_HIKER_SEX, H.ADK_HIKER_ADDRESS1, H.ADK_HIKER_ADDRESS2, H.ADK_HIKER_CITY, H.ADK_HIKER_STATE
				, H.ADK_HIKER_ZIP, H.ADK_HIKER_COUNTRY, H.ADK_HIKER_PERSONALINFO, H.ADK_HIKER_LASTACTIVE_DTE, H.ADK_HIKER_DTE
				, (SELECT U.ADK_USER_NAME FROM ADK_USER U WHERE U.ADK_USER_ID = H.ADK_HIKER_CORR_ID) ADK_HIKER_CORR_NAME
				, (SELECT COUNT(*)
					FROM ADK_HIKE_PEAK_JCT HP
						LEFT JOIN ADK_HIKE HI ON HP.ADK_HIKE_ID = HI.ADK_HIKE_ID
					WHERE HI.ADK_USER_ID = H.ADK_USER_ID) ADK_HIKER_NUMCLIMBED
				, (SELECT COUNT(DISTINCT ADK_PEAK_ID)
					FROM ADK_HIKE_PEAK_JCT HP
						LEFT JOIN ADK_HIKE HI ON HP.ADK_HIKE_ID = HI.ADK_HIKE_ID
					WHERE HI.ADK_USER_ID = H.ADK_USER_ID) ADK_HIKER_NUMPEAKS
			FROM ADK_HIKER H
				LEFT JOIN ADK_USER U ON H.ADK_USER_ID = U.ADK_USER_ID
			WHERE H.ADK_USER_ID = ?;"
        );

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}
	
	// Login
	function sql_login_check($con, $ADK_USER_USERNAME, $ADK_USER_PASSWORD) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_USER_ID, A.ADK_USER_USERNAME, A.ADK_USERGROUP_ID, A.ADK_USER_NAME, A.ADK_USER_EMAIL,
				B.ADK_USERGROUP_CDE, B.ADK_USERGROUP_DESC
			FROM ADK_USER A
				LEFT JOIN ADK_USERGROUP B ON A.ADK_USERGROUP_ID = B.ADK_USERGROUP_ID
			WHERE ADK_USER_USERNAME = ?
				AND ADK_USER_PASSWORD = ?;"
        );

        $sql_query->bind_param('ss', $ADK_USER_USERNAME, $ADK_USER_PASSWORD);

        return $sql_query;
	}
	
	// Message
	function sql_getMessage($con, $ADK_MESSAGE) {
		$sql_query = $con->prepare(
            "SELECT M.ADK_MESSAGE_ID, M.ADK_MESSAGE_FROM_USER_ID, M.ADK_MESSAGE_TO_USER_ID
				,M.ADK_MESSAGE_TITLE, M.ADK_MESSAGE_CONTENT, M.ADK_MESSAGE_DTE, M.ADK_MESSAGE_READ, M.ADK_MESSAGE_DRAFT
				,(SELECT ADK_USER_USERNAME FROM ADK_USER U WHERE U.ADK_USER_ID = M.ADK_MESSAGE_FROM_USER_ID) ADK_MESSAGE_FROM_USERNAME
				,(SELECT ADK_USER_NAME FROM ADK_USER U WHERE U.ADK_USER_ID = M.ADK_MESSAGE_FROM_USER_ID) ADK_MESSAGE_FROM_NAME
				,(SELECT ADK_USER_USERNAME FROM ADK_USER U WHERE U.ADK_USER_ID = M.ADK_MESSAGE_TO_USER_ID) ADK_MESSAGE_TO_USERNAME
				,(SELECT ADK_USER_NAME FROM ADK_USER U WHERE U.ADK_USER_ID = M.ADK_MESSAGE_TO_USER_ID) ADK_MESSAGE_TO_NAME
				,(SELECT CASE WHEN (SELECT COUNT(*) FROM ADK_HIKER H WHERE M.ADK_MESSAGE_FROM_USER_ID = H.ADK_USER_ID) > 0 THEN 1 ELSE 0 END) isFromHiker
			FROM ADK_MESSAGE M
			WHERE M.ADK_MESSAGE_ID = ?
				AND (M.ADK_MESSAGE_FROM_USER_ID = ? OR M.ADK_MESSAGE_TO_USER_ID = ?);"
        );

        $sql_query->bind_param('iii', $ADK_MESSAGE->id, $ADK_MESSAGE->userid, $ADK_MESSAGE->userid);

        return $sql_query;
	}
	function sql_getMessageFiles($con, $ADK_MESSAGE_ID) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_FILE_ID, A.ADK_FILE_NAME, A.ADK_FILE_DESC, A.ADK_FILE_SIZE
			FROM ADK_FILE A LEFT JOIN ADK_MESSAGE_FILE_JCT B ON A.ADK_FILE_ID = B.ADK_FILE_ID
			WHERE B.ADK_MESSAGE_ID = ?;"
        );

        $sql_query->bind_param('i', $ADK_MESSAGE_ID);

        return $sql_query;
	}
	
	function sql_getMessagesInbox($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_MESSAGE_ID, A.ADK_MESSAGE_FROM_USER_ID, A.ADK_MESSAGE_TO_USER_ID, A.ADK_MESSAGE_TITLE, A.ADK_MESSAGE_DTE, A.ADK_MESSAGE_READ
				,(SELECT ADK_USER_USERNAME FROM ADK_USER B WHERE B.ADK_USER_ID = A.ADK_MESSAGE_FROM_USER_ID) AS ADK_MESSAGE_FROM_USERNAME
				,(SELECT ADK_USER_USERNAME FROM ADK_USER B WHERE B.ADK_USER_ID = A.ADK_MESSAGE_TO_USER_ID) AS ADK_MESSAGE_TO_USERNAME
				,(SELECT COUNT(*) > 0 FROM ADK_MESSAGE_FILE_JCT C WHERE A.ADK_MESSAGE_ID = C.ADK_MESSAGE_ID) AS ADK_MESSAGE_HASFILES
			FROM ADK_MESSAGE A
			WHERE A.ADK_MESSAGE_TO_USER_ID = ?
				AND A.ADK_MESSAGE_TO_DELETED = 0
				AND A.ADK_MESSAGE_DRAFT = 0
			ORDER BY ADK_MESSAGE_DTE DESC;"
        );

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}
	
	function sql_getMessagesSent($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_MESSAGE_ID, A.ADK_MESSAGE_FROM_USER_ID, A.ADK_MESSAGE_TO_USER_ID, A.ADK_MESSAGE_TITLE, A.ADK_MESSAGE_DTE, A.ADK_MESSAGE_READ
				,(SELECT ADK_USER_USERNAME FROM ADK_USER B WHERE B.ADK_USER_ID = A.ADK_MESSAGE_FROM_USER_ID) AS ADK_MESSAGE_FROM_USERNAME
				,(SELECT ADK_USER_USERNAME FROM ADK_USER B WHERE B.ADK_USER_ID = A.ADK_MESSAGE_TO_USER_ID) AS ADK_MESSAGE_TO_USERNAME
				,(SELECT COUNT(*) > 0 FROM ADK_MESSAGE_FILE_JCT C WHERE A.ADK_MESSAGE_ID = C.ADK_MESSAGE_ID) AS ADK_MESSAGE_HASFILES
			FROM ADK_MESSAGE A
			WHERE A.ADK_MESSAGE_FROM_USER_ID = ?
				AND A.ADK_MESSAGE_FROM_DELETED = 0
				AND A.ADK_MESSAGE_DRAFT = 0
			ORDER BY ADK_MESSAGE_DTE DESC;"
        );

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}
	
	function sql_getMessagesDrafts($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_MESSAGE_ID, A.ADK_MESSAGE_FROM_USER_ID, A.ADK_MESSAGE_TO_USER_ID, A.ADK_MESSAGE_TITLE, A.ADK_MESSAGE_DTE, A.ADK_MESSAGE_READ
				,(SELECT ADK_USER_USERNAME FROM ADK_USER B WHERE B.ADK_USER_ID = A.ADK_MESSAGE_FROM_USER_ID) AS ADK_MESSAGE_FROM_USERNAME
				,(SELECT ADK_USER_USERNAME FROM ADK_USER B WHERE B.ADK_USER_ID = A.ADK_MESSAGE_TO_USER_ID) AS ADK_MESSAGE_TO_USERNAME
				,(SELECT COUNT(*) > 0 FROM ADK_MESSAGE_FILE_JCT C WHERE A.ADK_MESSAGE_ID = C.ADK_MESSAGE_ID) AS ADK_MESSAGE_HASFILES
			FROM ADK_MESSAGE A
			WHERE A.ADK_MESSAGE_FROM_USER_ID = ?
				AND A.ADK_MESSAGE_FROM_DELETED = 0
				AND A.ADK_MESSAGE_DRAFT = 1
			ORDER BY ADK_MESSAGE_DTE DESC;"
        );

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}
	
	function sql_getNewMessageCount($con, $ADK_USER_ID) {
		$sql_query = $con->prepare("SELECT COUNT(*) AS COUNT FROM ADK_MESSAGE WHERE ADK_MESSAGE_TO_USER_ID = ? AND ADK_MESSAGE_READ = 0 AND ADK_MESSAGE_DRAFT = 0;");

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}

	function sql_getTemplates($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT ADK_MSG_TMPL_ID, ADK_USER_ID, ADK_MSG_TMPL_NAME FROM ADK_MSG_TMPL
			WHERE ADK_USER_ID = ? OR ADK_USER_ID IS NULL
			ORDER BY ADK_MSG_TMPL_ID DESC, ADK_MSG_TMPL_NAME;"
        );
		
        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}

	function sql_getTemplate($con, $ADK_MSG_TMPL_ID) {
		$sql_query = $con->prepare(
            "SELECT ADK_USER_ID, ADK_MSG_TMPL_NAME, ADK_MSG_TMPL_CONTENT, ADK_MSG_TMPL_DTE
			FROM ADK_MSG_TMPL WHERE ADK_MSG_TMPL_ID = ?;"
        );
		
        $sql_query->bind_param('i', $ADK_MSG_TMPL_ID);

        return $sql_query;
	}
	
	// Peak
	function sql_getPeaks($con) {
		$sql_query = $con->prepare("SELECT ADK_PEAK_ID, ADK_PEAK_NAME, ADK_PEAK_HEIGHT FROM ADK_PEAK");
        return $sql_query;
	}

	function sql_getRemainingPeaks($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
            "SELECT A.ADK_PEAK_ID, A.ADK_PEAK_NAME, A.ADK_PEAK_HEIGHT,
				CASE WHEN A.ADK_PEAK_ID IN(
					SELECT B.ADK_PEAK_ID FROM ADK_HIKE_PEAK_JCT B
						LEFT JOIN ADK_HIKE C ON B.ADK_HIKE_ID = C.ADK_HIKE_ID
					WHERE C.ADK_USER_ID = ?) 
                THEN 1 ELSE 0 END AS ADK_PEAK_COMPLETE
			FROM ADK_PEAK A;"
        );

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}

	function sql_getPeakNames($con, $ADK_PEAK_IDS) {
		$sql_query = $con->prepare("SELECT GROUP_CONCAT(ADK_PEAK_NAME SEPARATOR ', ') FROM ADK_PEAK WHERE ADK_PEAK_ID IN($ADK_PEAK_IDS);");
		return $sql_query;
	}
	
	// Pref
	function sql_getUsersPrefs($con, $ADK_USER_ID) {
		$sql_query = $con->prepare(
			"SELECT P.ADK_PREF_NAME
				, CASE WHEN (SELECT COUNT(*) FROM ADK_USER_PREF UP
						WHERE UP.ADK_PREF_NAME = P.ADK_PREF_NAME
							AND UP.ADK_USER_ID = ?) = 1
					THEN (SELECT UP.ADK_PREF_VAL FROM ADK_USER_PREF UP
							WHERE UP.ADK_PREF_NAME = P.ADK_PREF_NAME
								AND UP.ADK_USER_ID = ?)
					ELSE P.ADK_PREF_DEFAULT
				END ADK_PREF_VAL
			FROM ADK_PREF P;"
		);

        $sql_query->bind_param('ii', $ADK_USER_ID, $ADK_USER_ID);

        return $sql_query;
	}

	function sql_isPrefSet($con, $ADK_USER_ID, $ADK_PREF_NAME) {
		$sql_query = $con->prepare("SELECT COUNT(*) COUNT FROM ADK_USER_PREF WHERE ADK_USER_ID = ? AND ADK_PREF_NAME = ?;");

        $sql_query->bind_param('is', $ADK_USER_ID, $ADK_PREF_NAME);

        return $sql_query;
	}

	// User
	function sql_getUser($con, $ADK_USER_ID) {
		$sql_query = $con->prepare("SELECT ADK_USER_USERNAME, ADK_USER_NAME, ADK_USER_EMAIL FROM ADK_USER WHERE ADK_USER_ID = ?;");

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}

	function sql_getUserEmail($con, $ADK_USER_ID) {
		$sql_query = $con->prepare("SELECT ADK_USER_EMAIL FROM ADK_USER WHERE ADK_USER_ID = ?;");

        $sql_query->bind_param('i', $ADK_USER_ID);

        return $sql_query;
	}
	
	function sql_checkUsernameNotExists($con, $ADK_USER_USERNAME) {
		$sql_query = $con->prepare("SELECT COUNT(*) AS COUNT FROM ADK_USER WHERE ADK_USER_USERNAME = ?;");

        $sql_query->bind_param('s', $ADK_USER_USERNAME);

        return $sql_query;
	}
	
	function sql_checkUserOldPassword($con, $ADK_USER_ID, $ADK_USER_PASSWORD) {
		$sql_query = $con->prepare("SELECT COUNT(*) AS COUNT FROM ADK_USER WHERE ADK_USER_ID = ? AND ADK_USER_PASSWORD = ?;");

		$pw = md5($ADK_USER_PASSWORD);

        $sql_query->bind_param('is', $ADK_USER_ID, $pw);

        return $sql_query;
	}
	
	function sql_isUser($con, $ADK_USER) {
        $sql_query = $con->prepare(
            "SELECT ADK_USER_ID, ADK_USER_USERNAME, ADK_USER_NAME, ADK_USER_EMAIL,
				RIGHT(ADK_USER_PASSWORD, 8) AS last8hash
			FROM ADK_USER
			WHERE ADK_USER_USERNAME = ? AND ADK_USER_EMAIL = ?;"
        );

        $sql_query->bind_param('ss', $ADK_USER->username, $ADK_USER->email);

        return $sql_query;
	}
	
	function sql_checkValidHash($con, $ADK_USER_ID, $last8hash) {
		$sql_query = $con->prepare("SELECT COUNT(*) AS COUNT FROM ADK_USER WHERE ADK_USER_ID = ? AND RIGHT(ADK_USER_PASSWORD, 8) = ?;");

        $sql_query->bind_param('is', $ADK_USER_ID, $last8hash);

        return $sql_query;
	}

	function sql_isUniqueUsername($con, $username, $exempt) {
		$sql_query = $con->prepare(
			"SELECT
				(SELECT COUNT(*) FROM ADK_USER WHERE ADK_USER_USERNAME = ? AND ADK_USER_USERNAME <> ?) +
				(SELECT COUNT(*) FROM ADK_APPLICANT WHERE ADK_APPLICANT_USERNAME = ? AND ADK_APPLICANT_USERNAME <> ?)
			AS COUNT;"
		);
				
		$sql_query->bind_param('ssss', $username, $exempt, $username, $exempt);
				
		return $sql_query;
	}
	
	// Batch
	function sql_batch_inactiveUsers($con) {
		$sql_query = $con->prepare(
            "SELECT DISTINCT H.ADK_USER_ID, U.ADK_USER_USERNAME, U.ADK_USER_NAME, U.ADK_USER_EMAIL, H.ADK_HIKER_CORR_ID
				, (SELECT CONCAT(U.ADK_USER_NAME, ' (', U.ADK_USER_USERNAME, ')')
					FROM ADK_USER U
					WHERE H.ADK_HIKER_CORR_ID = U.ADK_USER_ID) ADK_HIKER_CORR_NAME
			FROM ADK_HIKER H
				LEFT JOIN ADK_USER U ON H.ADK_USER_ID = U.ADK_USER_ID
                LEFT JOIN ADK_HIKE HI ON U.ADK_USER_ID = HI.ADK_USER_ID
			WHERE ADK_HIKER_LASTACTIVE_DTE > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -6 MONTH)
				AND (SELECT COUNT(DISTINCT ADK_PEAK_ID)
					FROM ADK_HIKE_PEAK_JCT HP
						LEFT JOIN ADK_HIKE HI ON HP.ADK_HIKE_ID = HI.ADK_HIKE_ID
					WHERE HI.ADK_USER_ID = H.ADK_USER_ID) < 46
				AND CASE WHEN (SELECT COUNT(*) FROM ADK_USER_PREF UP
						WHERE UP.ADK_PREF_NAME = 'hiker_receive-inactive-user-emails'
							AND UP.ADK_USER_ID = H.ADK_USER_ID) = 1
					THEN (SELECT UP.ADK_PREF_VAL FROM ADK_USER_PREF UP
							WHERE UP.ADK_PREF_NAME = 'hiker_receive-inactive-user-emails'
								AND UP.ADK_USER_ID = H.ADK_USER_ID)
					ELSE 1
				END = 1;"
        );

        return $sql_query;
	}
	
?>