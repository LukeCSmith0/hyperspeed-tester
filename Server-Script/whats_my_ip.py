from flask import Flask
from flask import jsonify
from flask import request

app = Flask(__name__)
@app.route("/whats-my-ip")
def main():
	return jsonify({"ip" : request.remote_addr}), 200
if __name__ == "__main__":
	app.run(host="88.98.192.97", port="6729")
