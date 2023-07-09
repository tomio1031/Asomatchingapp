package main

import (
	"database/sql"
	"fmt"
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

func Create(s Student) (message interface{}) { 
	// データベースへの接続
	db, err := sql.Open("mysql", "LAA1417803:LAA1417803@tcp(mysql215.phy.lolipop.lan)/LAA1417803-matching?charset=utf8")
	if err != nil {
		return fmt.Sprintf("database connection failed: %v", err)
	}
	defer db.Close()

	// 学籍番号の重複チェック
	var exists int
	err = db.QueryRow("SELECT COUNT(*) FROM students WHERE student_id = ?", s.StudentID).Scan(&exists)
	if err != nil {
		return fmt.Sprintf("failed to check if student ID exists: %v", err)
	}

	if exists > 0 {
		return "the student ID already exists"
	}

	// データベースへのインサート
	stmt, err := db.Prepare("INSERT INTO students(student_id, name, age, gender, password, hobby) VALUES(?, ?, ?, ?, ?, ?)")
	if err != nil {
		return fmt.Sprintf("failed to prepare insert statement: %v", err)
	}

	_, err = stmt.Exec(s.StudentID, s.Name, s.Age, s.Gender, s.Password, s.Hobby)
	if err != nil {
		return fmt.Sprintf("failed to execute insert statement: %v", err)
	}

	// 成功メッセージを返す
	return "Student successfully created"
}
