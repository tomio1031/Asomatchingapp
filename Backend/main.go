package main

import (
	"encoding/json"
	"net/http"
	"github.com/asoMatching/package"
)

type Message struct {
	Text string `json:"text"`
}

func main() {
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		var message dao.Message
		message.Text = "No API exists"

		r.ParseForm()

		if r.Form["create"] != nil {
			studentID := r.FormValue("student_id")
			name := r.FormValue("name")
			age := r.FormValue("age")
			gender := r.FormValue("gender")
			password := r.FormValue("password")
			hobby := r.FormValue("hobby")
			message = dao.Create(studentID, name, age, gender, password, hobby)
		}

		json.NewEncoder(w).Encode(message)
	})

	http.ListenAndServe(":8000", nil)
}
