import asyncio
import random
import pyautogui
questions = [
    {"Question 1":
        [
            {"true answer": "true answer 1"},
            {"option 1": "option 1"},
            {"option 2": "option 2"},
            {"option 3": "option 3"}
        ]
    },

    {"Question 2":
        [
            {"true answer": "true answer 2"},
            {"option 1": "option 4"},
            {"option 2": "option 5"},
            {"option 3": "option 6"}
        ]
    },

    {"Question 3":
        [
            {"true answer": "true answer 3"},
            {"option 1": "option 7"},
            {"option 2": "option 8"},
            {"option 3": "option 9"}
        ]
    }
]

c = 0
tr = None
theNumberOfTrueAnswers = 0

async def askquestion():
    global c
    global tr
    firstrow = questions[c]
    question = list(firstrow.keys())[0]
    print("*** " + question + " ***")
    options = firstrow[question]
    random.shuffle(options)

    for i in options:
        if list(i.keys())[0] == "true answer":
            tr = list(i.values())[0]
        print(list(i.values())[0])

   
async def write():
    global c
    global theNumberOfTrueAnswers

    try:
        # Ограничиваем время ожидания 3 секундами для ввода ответа
        answer = await asyncio.wait_for(asyncio.to_thread(input, "answer: "), timeout=5.0)

        # Проверяем, если ответ правильный
        if answer == tr:
            theNumberOfTrueAnswers += 1
    except asyncio.TimeoutError:
        # Если время истекло, выводим правильный ответ и продолжаем
        print("Время вышло! Правильный ответ: " + tr)
        pyautogui.press('enter')

# Главная функция для запуска
async def main():
    global c
    for i in range(3):  # Задаем 3 вопроса
        await asyncio.gather(askquestion(), write())
        c += 1  # Переход к следующему вопросу

    print(f"Number of correct answers: {theNumberOfTrueAnswers}")

# Запуск асинхронного кода
asyncio.run(main())
