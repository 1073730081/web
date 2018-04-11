#!usr/bin/python
# encoding:utf-8

import BaseHTTPServer as hs
import os


class ServerException(Exception):
    pass


class RequestHandler(hs.BaseHTTPRequestHandler):
    def send_content(self, page, status=200):

        self.send_response(status)
        self.send_header("Content-type", "text/html")
        self.send_header("Content-Length", str(len(page)))
        self.end_headers()
        self.wfile.write(page)
        # print(page)

    def send_css(self, page, status=200):
        self.send_response(status)
        self.send_header("Content-type", "text/css")
        self.send_header("Content-Length", str(len(page)))
        self.end_headers()
        self.wfile.write(page)

    def send_png(self, page, status=200):
        self.send_response(status)
        self.send_header("Content-type", "image/png")
        self.send_header("Content-Length", str(len(page)))
        self.end_headers()
        self.wfile.write(page)

    def do_GET(self):
        try:

            full_path = os.getcwd() + self.path
            # print full_path
            # os.startfile(full_path)
            # path is correct

            if not os.path.exists(full_path):

                raise ServerException("'{0}' not found".format(self.path))

            elif os.path.isfile(full_path):

                self.handle_file(full_path)

            else:

                raise ServerException("Unknown object '{0}'".format(self.path))

        except Exception as msg:

            self.handle_error(msg)

    def handle_file(self, full_path):

        try:

            with open(full_path, 'rb') as f:

                content = f.read()
            if full_path[-4:] == "html":
                self.send_content(content, 200)
            if full_path[-3:] == "css":
                self.send_css(content, 200)
            if full_path[-3:] == "png":
                self.send_png(content, 200)
            else:
                self.send_content(content, 200)
            #self.send_content(content, 200)

        except IOError as msg:

            msg = "'{0}' cannot be read: {1}".format(self.path, msg)

            self.handle_error(msg)

    Error_Page = """\
    <html>
    <body>
    <h1>Error accessing {path}</h1>
    <p>{msg}</p>
    </body>
    </html>
    """

    def handle_error(self, msg):

        content = self.Error_Page.format(path=self.path, msg=msg)

        self.send_content(content, 404)


if __name__ == '__main__':
    httpAddress = ('', 6699)

    httpd = hs.HTTPServer(httpAddress, RequestHandler)

    httpd.serve_forever()
