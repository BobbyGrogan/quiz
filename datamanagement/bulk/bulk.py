questions = """Who was the 1st president? ++ Who was the 2nd president? ++ Who was the 3rd president? ++ Who was the 4th president? ++ Who was the 5th president? ++ Who was the 6th president? ++ Who was the 7th president? ++ Who was the 8th president? ++ Who was the 9th president? ++ Who was the 10th president? ++ Who was the 11th president? ++ Who was the 12th president? ++ Who was the 13th president? ++ Who was the 14th president? ++ Who was the 15th president? ++ Who was the 16th president? ++ Who was the 17th president? ++ Who was the 18th president? ++ Who was the 19th president? ++ Who was the 20th president? ++ Who was the 21st president? ++ Who was the 22nd president? ++ Who was the 23rd president? ++ Who was the 24th president? ++ Who was the 25th president? ++ Who was the 26th president? ++ Who was the 27th president? ++ Who was the 28th president? ++ Who was the 29th president? ++ Who was the 30th president? ++ Who was the 31st president? ++ Who was the 32nd president? ++ Who was the 33rd president? ++ Who was the 34th president? ++ Who was the 35th president? ++ Who was the 36th president? ++ Who was the 37th president? ++ Who was the 38th president? ++ Who was the 39th president? ++ Who was the 40th president? ++ Who was the 41st president? ++ Who was the 42nd president? ++ Who was the 43rd president? ++ Who was the 44th president? ++ Who was the 45th president? ++ Who was the 46th president?"""
category_id = '16'
answers = """2190 ++ 2191 ++ 2192 ++ 2193 ++ 2194 ++ 2195 ++ 2196 ++ 2197 ++ 2198 ++ 2199 ++ 2200 ++ 2201 ++ 2202 ++ 2203 ++ 2204 ++ 2205 ++ 2206 ++ 2207 ++ 2208 ++ 2209 ++ 2210 ++ 2211 ++ 2212 ++ 2213 ++ 2214 ++ 2215 ++ 2216 ++ 2217 ++ 2218 ++ 2219 ++ 2220 ++ 2221 ++ 2222 ++ 2223 ++ 2224 ++ 2225 ++ 2226 ++ 2227 ++ 2228 ++ 2229 ++ 2230 ++ 2231 ++ 2232 ++ 2233 ++ 2234 ++ 2235"""
last_q_id = 248

#questions = "What is 1+1? ++ What is 2+2? ++ What is 3+2?"
#category = "addition"
#answers = "2 ++ 4 ++ 5 ++ 6"
#last_q_id = 5

questions = questions.split("++")
answers = answers.split("++")
cat_table = "cat__" + category_id

print("\n\n\n\n")

q_inc = -1

for n in questions:
    q_inc += 1
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
    add_q_cats = "CREATE TABLE " + q_cats + """ (
                qc_id INT AUTO_INCREMENT PRIMARY KEY,
                cat_id INT,
                asked INT DEFAULT 0,
                correct INT DEFAULT 0,
                time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
                FOREIGN KEY (cat_id) REFERENCES categories (cat_id));"""
    add_q_to_cat = "INSERT INTO " + cat_table + " (q_id) VALUES (" + str(last_q_id) + ");"

    print(add_question + "\n")
    print(add_q_ans + "\n")
    print(add_q_cats + "\n")
    print(add_q_to_cat + "\n")
    
    for z in answers:
        answer = z.strip()
        if q_inc != answers.index(z):
            add_answers = "INSERT INTO " + q_ans + " (`a_id`, `is_true`) VALUES ('" + answer + "', 0);"
            print(add_answers)
        else:
            add_answers = "INSERT INTO " + q_ans + " (`a_id`, `is_true`) VALUES ('" + answer + "', 1);"
            print(add_answers)
    print("\n\n")



    # print(add_question + "\n\n")
    # print(add_q_ans + "\n\n")
    # print(add_q_cats + "\n\n")

print("\n\n\n\n")
