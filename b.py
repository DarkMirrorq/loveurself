import aiogram.utils.markdown as md
from aiogram import types, Dispatcher
from aiogram.contrib.middlewares.logging import LoggingMiddleware
from aiogram.dispatcher import FSMContext
from aiogram.types import ParseMode
from aiogram.utils import executor
import pymysql

api_token = 'YOUR_API_TOKEN'

conn = pymysql.connect(
    host='YOUR_HOST',
    port=int(3306),
    user='YOUR_USER',
    password='YOUR_PASSWORD',
    db='YOUR_DB',
    charset='utf8mb4',
    cursorclass=pymysql.cursors.DictCursor
)

bot = types.Bot(token=api_token)
dp = Dispatcher(bot)
dp.middleware.setup(LoggingMiddleware())

@dp.message_handler(commands=['start'])
async def process_start_command(message: types.Message):
    await message.reply("İşte bir başlangıç komutudur.")

@dp.message_handler(commands=['tc'])
async def process_tc_command(message: types.Message):
    user_input = message.get_args()
    try:
        tc_no = int(user_input)
    except ValueError:
        await message.reply("TC numarası geçersiz.")
        return

    with conn.cursor() as cursor:
        cursor.execute("SELECT ADI FROM 101m WHERE TC=%s", (tc_no,))
        result = cursor.fetchone()

    if result:
        await message.reply(f"TC numarasına ait kişi adı: {result['ADI']}")
    else:
        await message.reply("TC numarası bulunamadı.")

if __name__ == '__main__':
    executor.start_polling(dp, skip_updates=True)
