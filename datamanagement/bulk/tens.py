inc = 1

while inc < 422:
    stmt = "UPDATE `qans__" + str(inc) + "` SET `codes` = 2 WHERE`a_id` = 10;"
    print(stmt)
    inc += 1