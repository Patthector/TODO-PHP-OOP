# ---------------------
# TABLE: todo_app_todos 
# ---------------------
#
# MySql-syntax
# -------------
# CREATE TABLE todo_app_todos (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(500),
    description TEXT,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, 
    id_collection INTEGER DEFAULT NULL,
    id_subcollection INTEGER DEFAULT NULL,
    id_user INTEGER,
    FOREIGN KEY (id_collection) REFERENCES todo_app_collections(id),
    FOREIGN KEY (id_collection) REFERENCES todo_app_collections(id),
    FOREIGN KEY (id_user) REFERENCES todo_app_users(id));
#---------------------------------------------------------------
#
# ---------------------------
# TABLE: todo_app_collections
# ---------------------------
# 
# MySql-syntax
# ------------
# CREATE TABLE todo_app_collections (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(250),
	description VARCHAR(500),
	id_author INTEGER,
	created_date DATETIME DEFAULT CURRENT TIMESTAMP,
	FOREIGN KEY (id_user) REFERENCES users
);
#---------------------------------------------------------------
#
# ------------------------------
# TABLE: todo_app_subcollections
# ------------------------------
# 
# MySql-syntax
# ------------
# CREATE TABLE todo_app_subcollections (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(250),
    description VARCHAR(500),
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_collection INTEGER,
    id_author VARCHAR(50),
    FOREIGN KEY (id_collection) REFERENCES collections,    
    FOREIGN KEY (id_user) REFERENCES users
);
#---------------------------------------------------------------
#
# ---------------------
# TABLE: todo_app_users
# ---------------------
# 
# MySql-syntax
# ------------
# CREATE TABLE todo_app_users (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	first_name VARCHAR(250),
	last_name VARCHAR(500),
	password VARCHAR(25)
);
#---------------------------------------------------------------
#
# ---------------------------------
# QUERY: creating TESTS Collections
# ---------------------------------
# 
# MySql-syntax
# ------------
# INSERT INTO todo_app_collections VALUES (
   NULL, 
   "Collection_1",
   "Description_1",
   1,
   CURRENT_TIMESTAMP() );
   
INSERT INTO todo_app_collections VALUES (
   NULL, 
   "Collection_2",
   "Description_2",
   1,
   CURRENT_TIMESTAMP() );
   
INSERT INTO todo_app_collections VALUES (
   NULL, 
   "Collection_3",
   "Description_3",
   1,
   CURRENT_TIMESTAMP() );
#
#
#
#
#
#
#---------------------------------------------------------------
#
# ---------------------------------
# QUERY: creating TESTS TODOS
# ---------------------------------
# 
# MySql-syntax
# ------------
#INSERT INTO todo_app_todos VALUES (
    NULL,
    "Todo_1",
    "Description_1 for todo_1",
    CURRENT_TIMESTAMP(),
    NULL,
    3,
    1
);