from flask import Flask
from flask import jsonify
from flask import request

app = Flask(__name__)
@app.route("/whats-my-ip")
def main():
	return jsonify({"ip" : request.remote_addr}), 200
if __name__ == "__main__":
	app.run(host="X.X.X.X", port="Y")
