from flask import Flask
from flask import jsonify
from flask import request
import logging
from logging.handlers import RotatingFileHandler
#from logging import Formatter

app = Flask(__name__)
@app.route("/")
def main():
        log = logging.getLogger('werkzeug')
        log.setLevel(logging.WARNING)
        handler = logging.handlers.RotatingFileHandler(
        '/home/whats-my-ip/logs.log'
        )
        log.addHandler(handler)
        return jsonify({"ip" : request.remote_addr}), 200
        return "Chickens"
if __name__ == "__main__":
        app.run(host="X.X.X.X", port="Y")
