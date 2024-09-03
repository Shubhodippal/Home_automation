#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h> 

const char* ssid = "";
const char* password = "";
const char* serverUrl = "";

const int relayCount = 4;
const int relayPins[relayCount] = {2, 3, 4, 5}; 

int ids[relayCount];
String states[relayCount]; 
String names[relayCount];

void setup() {
  Serial.begin(115200);

  for (int i = 0; i < relayCount; i++) {
    pinMode(relayPins[i], OUTPUT);
    digitalWrite(relayPins[i], LOW);  
  }

  WiFi.begin(ssid, password);

  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }

  Serial.println("Connected to WiFi");
    
}

void loop() {
  
  String data = fetchDataFromServer();
  
  DynamicJsonDocument doc(1024);
  deserializeJson(doc, data);

  int index = 0;

  for (JsonObject elem : doc.as<JsonArray>()) {
    if (index < relayCount){
      ids[index] = elem["id"].as<int>();  
      names[index] = elem["Appliances"].as<String>();
      states[index] = elem["state"].as<String>();  
      index++;
    }
  }

  for (int i = 0; i < relayCount; i++) {
    digitalWrite(relayPins[i], (states[i] == "on") ? HIGH : LOW);  
  }

  for (int i = 0; i < index; i++) {
    Serial.print("ID: " + String(ids[i]));
    Serial.print(" Name: " + names[i]);
    Serial.println(" State: " + String(states[i]));
  }

  delay(1000);
}

String fetchDataFromServer() {
  if(WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverUrl);

    int httpResponseCode = http.GET();
    if(httpResponseCode > 0) {
      String payload = http.getString();
      return payload;
            
    }else {
      Serial.println("Error on HTTP request: " + String(httpResponseCode));
    }
    http.end();
  }else {
    Serial.println("Error: Not connected to WiFi");
  }
}
