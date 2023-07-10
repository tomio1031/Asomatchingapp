package main

import (
	"database/sql"
	"encoding/json"
	"net/http"
	"log"
	"github.com/gorilla/mux"
	_ "github.com/go-sql-driver/mysql"
)

type User struct {
	StudentId string `json:"student_id"`
	Name      string `json:"name"`
	Age       int    `json:"age"`
	Gender    string `json:"gender"`
	Password  string `json:"password"`
	HobbyId string `json:"hobby_id"`
}

func main() {
	r := mux.NewRouter()
	r.HandleFunc("/create", CreateUser).Methods("POST", "OPTIONS")
	http.ListenAndServe(":8080", r)
}
func CreateUser(w http.ResponseWriter, r *http.Request) {
    w.Header().Set("Access-Control-Allow-Origin", "*")
    w.Header().Set("Access-Control-Allow-Methods", "POST")
    w.Header().Set("Access-Control-Allow-Headers", "Content-Type")

    // Stop here if its Preflighted OPTIONS request
    if r.Method == "OPTIONS" {
        return
    }

    var user User
    err := json.NewDecoder(r.Body).Decode(&user)
    if err != nil {
        w.Header().Set("Content-Type", "application/json")
        http.Error(w, `{"error": "`+err.Error()+`"}`, http.StatusBadRequest)
        return
    }

    db, err := sql.Open("mysql", "LAA1417803:LAA1417803@tcp(mysql215.phy.lolipop.lan)/LAA1417803-matching?charset=utf8")

    if err != nil {
		log.Println(err.Error())
        w.Header().Set("Content-Type", "application/json")
        http.Error(w, `{"error": "`+err.Error()+`"}`, http.StatusInternalServerError)
        return
    }
    defer db.Close()

	stmt, err := db.Prepare("INSERT INTO users(student_id, name, age, gender, password, hobby_id) VALUES(?, ?, ?, ?, ?, ?)")
	if err != nil {
		log.Println(err.Error())
		w.Header().Set("Content-Type", "application/json")
		http.Error(w, `{"error": "`+err.Error()+`"}`, http.StatusInternalServerError)
		return
	}
	_, err = stmt.Exec(user.StudentId, user.Name, user.Age, user.Gender, user.Password, user.HobbyId)
	if err != nil {
		log.Println(err.Error())
		w.Header().Set("Content-Type", "application/json")
		http.Error(w, `{"error": "`+err.Error()+`"}`, http.StatusInternalServerError)
		return
	}
	

    w.Header().Set("Content-Type", "application/json")
    json.NewEncoder(w).Encode(map[string]string{"message": "User created successfully"})
}
