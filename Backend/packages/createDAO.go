package packages

import (
	"database/sql"
	"fmt"
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

func Create(studentID string, name string, age string, gender string, password string, hobby string) (Student, error) {
	// DB接続
	db, err := sql.Open("mysql", "LAA1417803:LAA1417803@tcp(mysql215.phy.lolipop.lan)/LAA1417803-matching?charset=utf8")
	if err != nil {
		log.Fatal(err)
		return Student{}, fmt.Errorf("database connection failed: %v", err)
	}
	defer db.Close()

	// 学籍番号の重複チェック
	var exists int
	err = db.QueryRow("SELECT COUNT(*) FROM students WHERE student_id = ?", studentID).Scan(&exists)
	if err != nil {
		log.Fatal(err)
		return Student{}, fmt.Errorf("failed to check if student ID exists: %v", err)
	}

	if exists > 0 {
		return Student{}, fmt.Errorf("the student ID already exists")
	}

	// インサート処理
	stmt, err := db.Prepare("INSERT INTO students(student_id, name, age, gender, password, hobby) VALUES(?, ?, ?, ?, ?, ?)")
	if err != nil {
		log.Fatal(err)
		return Student{}, fmt.Errorf("failed to prepare insert statement: %v", err)
	}

	_, err = stmt.Exec(studentID, name, age, gender, password, hobby)
	if err != nil {
		log.Fatal(err)
		return Student{}, fmt.Errorf("failed to execute insert statement: %v", err)
	}

	// インサートした情報を返す
	return Student{
		StudentID: studentID,
		Name:      name,
		Age:       age,
		Gender:    gender,
		Password:  password,
		Hobby:     hobby,
	}, nil
}
