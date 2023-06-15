def get_order_suffix(number):
    suffixes = {
        1: "st",
        2: "nd",
        3: "rd"
    }
    if 10 < number < 14:
        return "th"
    return suffixes.get(number % 10, "th")

def generate_questions():
    for number in range(1, 47):
        order_suffix = get_order_suffix(number)
        question = f"Who was the {number}{order_suffix} president?"
        print(question)
        if number != 46:
            print("++")

# Generate the questions
generate_questions()
