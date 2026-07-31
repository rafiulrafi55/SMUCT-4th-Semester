import mysql.connector 

conn = mysql.connector.connect(
    host = "localhost",
    user = "root",
    password = "",
    database = "test"

)
cursor = conn.cursor()
print("Connection Successful")
cursor.execute("create table if not exists Student_info(id int(12),name char(50), phone int(13), address char(50))")
print("Table creation successful")

n = input("How many datas ? : ")
if n == "":
    pass
else:
    for i in range(int(n)):
        id = input("Enter your id : ")
        name = input("Enter your name : ")
        phone = input("Enter your phone number : ")
        address = input("Enter your address : ")

    cursor.execute("insert into Student_info values(%s,%s,%s,%s)",(id,name,phone,address))
    conn.commit()
    print("Data inserted successfully")
is_running = True
while is_running:
    choice = input("What do you want to do ?\n1. Show all data\n2. Search data\n3. Update data\n4. Delete data\n5. Exit\nEnter your choice : ")
    if choice == "1":
        cursor.execute("select * from Student_info")
        data = cursor.fetchall()
        for i in data:
            print(i)
    elif choice == "2":
        search_id = input("Enter the id to search : ")
        cursor.execute("select * from Student_info where id = %s",(search_id,))
        data = cursor.fetchall()
        for i in data:
            print(i)
    elif choice == "3":
        update_id = input("Enter the id to update : ")
        cursor.execute("select * from Student_info where id = %s",(update_id,))
        data = cursor.fetchall()
        for i in data:
            print(i)
        new_name = input("Enter the new name : ")
        new_phone = input("Enter the new phone number : ")
        new_address = input("Enter the new address : ")
        cursor.execute("update Student_info set name = %s, phone = %s, address = %s where id = %s",(new_name,new_phone,new_address,update_id))
        conn.commit()
        print("Data updated successfully")
    elif choice == "4":
        delete_id = input("Enter the id to delete : ")
        cursor.execute("select * from Student_info where id = %s",(delete_id,))
        data = cursor.fetchall()
        for i in data:
            print(i)
        confirm = input("Are you sure you want to delete this data ? (y/n) : ")
        if confirm == "y":
            cursor.execute("delete from Student_info where id = %s",(delete_id,))
            conn.commit()
            print("Data deleted successfully")
        else:
            print("Data deletion cancelled")
    elif choice == "5":
        is_running = False
        print("Exiting...")
        conn.close()
    



