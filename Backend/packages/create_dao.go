package packages

import (
	"database/sql"
	"log"
	_ "github.com/go-sql-driver/mysql"
)

type Student struct {
	StudentID string `json:"student_id"`
	Name      string `json:"name"`
	Age       string `json:"age"`
	Gender    string `json:"gender"`
	Password  string `json:"password"`
	Hobby     string `json:"hobby"`
}

func Create(s Student) interface{} {
	// DB接続
	db, err := sql.Open("mysql", "LAA1417803:LAA1417803@tcp(mysql215.phy.lolipop.lan)/LAA1417803-matching?charset=utf8")
	if err != nil {
		log.Fatal(err)
		return "database connection failed: " + err.Error()
	}
	defer db.Close()

	// 学籍番号の重複チェック
	var exists int
	err = db.QueryRow("SELECT COUNT(*) FROM students WHERE student_id = ?", s.StudentID).Scan(&exists)
	if err != nil {
		log.Fatal(err)
		return "failed to check if student ID exists: " + err.Error()
	}

	if exists > 0 {
		return "the student ID already exists"
	}

	// インサート処理
	stmt, err := db.Prepare("INSERT INTO students(student_id, name, age, gender, password, hobby) VALUES(?, ?, ?, ?, ?, ?)")
	if err != nil {
		log.Fatal(err)
		return "failed to prepare insert statement: " + err.Error()
	}

	_, err = stmt.Exec(s.StudentID, s.Name, s.Age, s.Gender, s.Password, s.Hobby)
	if err != nil {
		log.Fatal(err)
		return "failed to execute insert statement: " + err.Error()
	}

	// インサートした情報を返す
	return s
}
