SELECT
	A.student_id,
	t_student.sname,
	A.num
FROM
	(
		SELECT
			student_id,
			COUNT(course_id) AS num
		FROM
			t_score
		GROUP BY
			student_id
	) AS A
LEFT JOIN t_student ON t_student.sid = A.student_id;