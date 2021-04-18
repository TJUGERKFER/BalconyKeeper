#include <WiFi.h>
#include <WiFiClient.h>
#include <HTTPClient.h>
#include <DHT.h>
#include <EEPROM.h>
#include <ESP32Tone.h>
#define HONGWAI 13
#define DHT_11 12
#define LEDLIGHT 14
#define FENGMING 25
#define SHUIBENG 33
#define MOTOR_1 5
#define MOTOR_2 17
#define TURANG 34
const String host = "YOURHOST";
const String port = ":80";
auto ssid = "YOURSSID";
auto password = "YOURPASSWORD";
DHT dht2(DHT_11, 11);
bool alert, delayalert, rain;
int huapen = 1;
String tasks[10];
long thattime = millis();
String airhumi;
int humi, temp, pot, rcvalert;
float tonelist[] = {1046.5, 1174.7, 1318.5, 1396.9, 1568, 1760, 1975.5};
WiFiClient client;
HTTPClient http;

void resolvingtasks(String tasklist) {
  String tmp;
  int ptr = 1;
  int i = 0;
  while (i < tasklist.length()) {
    if (tasklist[i] != '&') {
      tmp += tasklist[i];
      i++;
    } else {
      i++;
      tasks[ptr] = tmp;
      tmp = "";
      ptr++;
    }
  }
  for (int i = 1; i <= ptr; i++) {
    if (tasks[i] == "alertonfalse") {
      alert = true;
      delayalert = false;
    }

    if (tasks[i] == "alertofffalse") {
      alert = false;
      delayalert = false;
    }

    if (tasks[i] == "alertontrue") {
      alert = true;
      delayalert = true;
    }

    if (tasks[i] == "alertofftrue") {
      alert = false;
      delayalert = true;
    }

    if (tasks[i] == "lighton") {
      onlight();
    }

    if (tasks[i] == "lightoff") {
      offlight();
    }

    if (tasks[i] == "closewindow") {
      closewindow();
    }

    if (tasks[i] == "rainclosewindow") {
      if (rain) {
        closewindow();
      }
    }
  }
}
String httprequestsend(String url) {
  Serial.println("[HTTP]发送请求");
  if (http.begin(client, url)) {  // 开启HTTP请求并判断是否成功
    int httpCode = http.GET(); //获取HTTP状态
    delay(0); //喂狗
    if (httpCode > 0) {
      Serial.printf("[HTTP] GET... code: %d\n", httpCode);
      if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) { //若请求成功
        String backcode = http.getString(); //获取返回值
        Serial.println(backcode);
        return (backcode);
      }
    } else {
      Serial.printf("[HTTP] 请求失败: %s\n", http.errorToString(httpCode).c_str());
      return "none";
    }
    http.end();
  } else {
    Serial.printf("[HTTP]请求失败\n");
    return "none";
  }
}

void water()
{
  Serial.println("[执行器]浇水中");
  digitalWrite(SHUIBENG, HIGH);
  delay(3000);
  digitalWrite(SHUIBENG, LOW);
  Serial.println("[执行器]浇水完毕");
  return;
}
void music()
{
  long musiclist[] = {3, 5, 6, 1, 2, 1, 2, 3, 1, 6, 5, 3, 1, 2, 6, 6, 1, 2, 1, 2, 3, 5, 6, 1, 7, 6, 5, 6, 5, 3, 2, 3, 1, 2, 1, 2, 3, 6, 1, 2, 1, 6, 6, 5, 6, 1, 2, 3, 2, 5, 6};
  long highlist[] = { -1, -1, -1, 0, 0, 0, 0, 0, 0, -1, -1, -1, 0, 0, -1, -1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, -1, 0, 0, 0, -1, -1, -1, -1, 0, 0, 0, 0, -1, -1};
  long updownlist[] = {0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
  float rhythmlist[] = {0.5, 0.5, 0.5, 0.5, 1, 0.5, 0.5, 1, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 1, 0.5, 0.5, 1, 0.5, 0.5, 1, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 1, 0.5, 0.5, 1, 0.5, 0.5, 1, 0.5, 0.5, 0.5, 0.5, 0.25, 0.25, 0.5, 1, 0.5, 0.5, 1, 0.5, 0.5, 0.5, 0.5, 1, 1};
  volatile long updown = -2;
  volatile float speed2 = 120;
  for (int i = 0; i < 52; i++) {
    tone(FENGMING, (tonelist[(int)(musiclist[(int)(i - 1)] - 1)] * pow(2, highlist[(int)(i - 1)])) * pow(2, (updownlist[(int)(i - 1)] + updown) / 12.0), ((1000 * (60 / speed2)) * rhythmlist[(int)(i - 1)]), 0);
    noTone(FENGMING);
    delay(0);
  }
}
void uploaddata() {
  if (WiFi.status() == WL_CONNECTED) {
    String url = "http://" + host + port + "/change.php?pot=" + String(pot) + "&temp=" + String(temp) + "&humi=" + String(humi) + "&airhumi=" + airhumi; //charhumi;
    Serial.println(url);
    delay(0);
    httprequestsend(url);
  }
}
void beep() {
  Serial.println("beep");
  for (int ii = 1; ii < 4; ii++) {
    tone(FENGMING, 1000, 500, 0);
    noTone(FENGMING);
    delay(500);
  }
}
void receivetask() {
  for (int i = 0; i < 10; i++) {
    tasks[i] = "";
  }
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    String url = "http://" + host + port + "/command.php?mode=get&pot=" + String(pot);
    String cloudcommand = httprequestsend(url);
    if (cloudcommand == "water") water();
    if (cloudcommand == "openwindow") openwindow();
    if (cloudcommand == "closewindow") closewindow();
    if (cloudcommand == "onlight") onlight();
    if (cloudcommand == "offlight") offlight();
    if (cloudcommand == "music") music();
    if (cloudcommand == "beep") beep();
    delay(0);
    url = "http://" + host + port + "/command.php?mode=autoget&pot=" + String(pot);
    cloudcommand = httprequestsend(url);
    if (cloudcommand == "water") water();
    if (cloudcommand == "beep") beep();
    if (cloudcommand == "music") music();
    delay(0);
    url = "http://" + host + port + "/command.php?mode=loadsetting";
    resolvingtasks(httprequestsend(url));
  }
  delay(0);
}
void antithief() {
  if (alert == true) {
    if (delayalert == true) {
      if (millis() - thattime <= 1800000) {
        return;
      }
    }
    thattime = millis();
    beep();
    String  url = "http://" + host + port + "/other.php?module=antithief&mode=write";
    String a = httprequestsend(url);
    Serial.println(a);
  }
}
void getdata() {
  humi = analogRead(TURANG);
  Serial.println(humi);
  temp = String(dht2.readTemperature()).toInt();
  if (digitalRead(HONGWAI)) antithief();
  airhumi = String(dht2.readHumidity()).toInt();
}
void connectwifi() {
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("连接中");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("连接成功!");
}
void onlight() {
  Serial.println("[执行器]开灯");
  digitalWrite(LEDLIGHT, HIGH);
}
void offlight() {
  Serial.println("[执行器]关灯");
  digitalWrite(LEDLIGHT, LOW);

}
void openwindow() {
  Serial.println("[执行器]开窗操作");
  digitalWrite(MOTOR_1, LOW);
  digitalWrite(MOTOR_2, HIGH);
  delay(6000);
  digitalWrite(MOTOR_1, LOW);
  digitalWrite(MOTOR_2, LOW);
  EEPROM.commit();
}
void closewindow() {
  Serial.println("[执行器]关窗操作");
  digitalWrite(MOTOR_1, HIGH);
  digitalWrite(MOTOR_2, LOW);
  delay(6000);
  digitalWrite(MOTOR_1, LOW);
  digitalWrite(MOTOR_2, LOW);
  //  EEPROM.write(DATA_WINDOW, 0);
  EEPROM.commit();
}
void opensound() {
  long musiclist[] = {1, 3, 5, 1};
  long highlist[] = {0, 0, 0, 1};
  long updownlist[] = {0, 0, 0, 0};
  float rhythmlist[] = {0.5, 0.5, 0.5, 0.5};
  volatile long updown = -2;
  volatile float speed2 = 120;
  for (int i = 1; i < 5; i++) {
    tone(FENGMING, (tonelist[(int)(musiclist[(int)(i - 1)] - 1)] * pow(2, highlist[(int)(i - 1)])) * pow(2, (updownlist[(int)(i - 1)] + updown) / 12.0), ((1000 * (60 / speed2)) * rhythmlist[(int)(i - 1)]), 0);
    noTone(FENGMING);
    delay(0);
  }
}
void setup() {
  pot = 1;
  Serial.begin(115200);
  pinMode(HONGWAI, INPUT);
  pinMode(LEDLIGHT, OUTPUT);
  pinMode(FENGMING, OUTPUT);
  pinMode(MOTOR_1, OUTPUT);
  pinMode(MOTOR_2, OUTPUT);
  pinMode(SHUIBENG, OUTPUT);
  pinMode(DHT_11, INPUT);
  digitalWrite(MOTOR_1, LOW);
  digitalWrite(MOTOR_2, LOW);
  connectwifi();
  opensound();
  EEPROM.begin(1024);
  dht2.begin();
}
void loop() {
  delay(300);
  getdata();//获取数据
  delay(0);
  uploaddata(); //上传数据到云端
  delay(0);
  receivetask();//下载任务
  delay(0);
}
