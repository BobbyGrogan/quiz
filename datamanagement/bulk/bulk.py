questions = input("questions: ")
category = input("category: ")
wrongs = input("wrongs: ")
corrects = input("corrects: ")
last_q_id = int(input("IMPORTANT last q_id: "))

questions = questions.split("++")
wrongs = wrongs.split("++")
corrects = corrects.split("++")
add_cat = ""

print("\n\n\n\n")

for n in questions:
    last_q_id += 1
    question = n.strip()
    add_q_id = ""
    q_ans = "qans__" + str(last_q_id)
    q_cats = "qcats__" + str(last_q_id)
    
    add_question = "INSERT INTO questions (question) VALUES ('" + question + "');"
    add_q_ans = "CREATE TABLE " + q_ans + """ (
                qa_id INT AUTO_INCREMENT PRIMARY KEY,
                a_id INT(32),
                is_true INT(8) DEFAULT 0,
                asked INT DEFAULT 0,
                correct INT DEFAULT 0,
                time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
                FOREIGN KEY (a_id) REFERENCES answers (a_id));"""
    add_q_cats = "CREATE TABLE " + q_ans + """ (
                qc_id INT AUTO_INCREMENT PRIMARY KEY,
                cat_id INT,
                asked INT DEFAULT 0,
                correct INT DEFAULT 0,
                time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
                FOREIGN KEY (cat_id) REFERENCES categories (cat_id));"""

    print(add_question + "\n\n")
    print(add_q_ans + "\n\n")
    print(add_q_cats + "\n\n")

print("\n\n\n\n")