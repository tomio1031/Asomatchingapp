package main

import (
	"encoding/json"
	"net/http"
	dao "github.com/matching/packages"
)

func main() {
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		var message dao.Message
		message.Text = "No API exists"

		r.ParseForm()

		if r.Form["create"] != nil {
			student := dao.Student{
				StudentID: r.FormValue("student_id"),
				Name:      r.FormValue("name"),
				Age:       r.FormValue("age"),
				Gender:    r.FormValue("gender"),
				Password:  r.FormValue("password"),
				Hobby:     r.FormValue("hobby"),
			}
			message, err := dao.Create(student)
			if err != nil {
				// handle error here
			}
		}

		json.NewEncoder(w).Encode(message)
	})

	http.ListenAndServe(":8000", nil)
}
