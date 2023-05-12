import mysql.connector
import pandas as pd

db = mysql.connector.connect(
    host="localhost",
    port="3306",
    username="root",
    password="123321",
    database="tenfe2"
)

colors = {
    'R1': 'bg-cyan-600',
    'R3': 'bg-red-600',
    'R4': 'bg-orange-600',
    'R11': 'bg-sky-600',
    'R12': 'bg-yellow-300',
}

df = pd.read_excel('./Horaris.xlsx')
cursor = db.cursor()

# Agafem tots els valors unics de LINIA
linies = df['LINIA'].unique()
# Les afegim a la db
for linia in linies:
    sql = "SELECT * FROM tenfe2.routes WHERE name = %s"
    cursor.execute(sql, (linia,))
    result = cursor.fetchall()

    if not result:
        sql = "INSERT INTO tenfe2.routes (name,colour) VALUES (%s,%s)"
        cursor.execute(sql, (linia, colors[linia]))
        db.commit()

# Agafem tots els valors unics de ID_PARADA
estacions = df['ID_PARADA'].unique()
# Les afegim a la db
for es in estacions:
    sql = "SELECT * FROM tenfe2.stations WHERE name = %s"
    cursor.execute(sql, (es,))
    result = cursor.fetchall()

    if not result:
        sql = "INSERT INTO tenfe2.stations (name) VALUES (%s)"
        cursor.execute(sql, (es,))
        db.commit()

df['HORA'] = df['HORA'].apply(lambda x: x.strftime('%H:%M'))

# Inserim a la db els schedules i route_trains
for row in df.itertuples():
    sql = "SELECT * FROM tenfe2.schedules WHERE train_num = %s AND stop_number = %s"
    cursor.execute(sql, (row.ID_VIAJE, row.ORDEN))
    result = cursor.fetchall()

    if not result:
        sql = "INSERT INTO tenfe2.schedules (station_id, time, train_num, stop_number) VALUES (%s,%s,%s,%s)"

        stId = None
        sql2 = "SELECT id FROM tenfe2.stations WHERE name = %s"
        cursor.execute(sql2, (row.ID_PARADA,))
        result = cursor.fetchall()
        if result:
            stId = result[0][0]
            cursor.execute(sql, (stId, row.HORA, row.ID_VIAJE, row.ORDEN))
            db.commit()

df2 = df[['LINIA','ID_VIAJE']].drop_duplicates()

for row in df2.itertuples():
    sql = "SELECT * FROM tenfe2.route_trains WHERE route_id = %s AND train_num = %s"
    cursor.execute(sql, (row.LINIA, row.ID_VIAJE))
    result = cursor.fetchall()

    if not result:
        sql = "INSERT INTO tenfe2.route_trains (route_id, train_num) VALUES (%s,%s)"

        cursor.execute(sql, (row.LINIA, row.ID_VIAJE))
        db.commit()
