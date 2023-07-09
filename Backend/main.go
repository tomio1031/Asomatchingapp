package main

import (
	"encoding/json"
	"net/http"
	"github.com/matching/Backend/matching"
)

func main() {
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		if r.Method != http.MethodPost {
			http.Error(w, "Invalid request method", http.StatusMethodNotAllowed)
			return
		}

		var s matching.Student // <- matching.Student型を使用
		err := json.NewDecoder(r.Body).Decode(&s)
		if err != nil {
			http.Error(w, err.Error(), http.StatusBadRequest)
			return
		}

		message := matching.Create(s) // <- matching.Create関数を使用

		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(message)
	})

	http.ListenAndServe(":8000", nil)
}
