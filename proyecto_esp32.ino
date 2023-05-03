#include <Arduino.h>
#include <Wire.h>
#include <WiFi.h>
#include "EmonLib.h"
#include <ThingerESP32.h>
#include <ThingerWifi.h>

#define USERNAME "IsaiMadrigal"
#define DEVICE_ID "ESP32"
#define DEVICE_CREDENTIAL "Tamalito26"

ThingerESP32 thing(USERNAME, DEVICE_ID, DEVICE_CREDENTIAL);


//Definimos datos de conexión WIFI

const char* ssid = "Totalplay-51A7"; // SSID wifi
const char* pass = "Tamalito265G"; // Clave Wifi

//Programación SCT010, se crea una instancia EnergyMonitor, se definen valores de votaje y puerto
EnergyMonitor MonitorEnergia;
float voltajeRed = 120.0;
double potencia;
double Irms;
#define analogpin 34

const int FLOW_SENSOR_PIN = 23; // Conectado al pin de interrupción 4 del ESP32
volatile unsigned int pulse_count = 0;
const float FLOW_FACTOR = 7.5; // Factor de conversión para el sensor YF-201

void IRAM_ATTR flow_sensor_isr() {
  pulse_count++;
}

void setup() {

  Serial.begin(115200);
  
  // Número de pin: donde tenemos conectado el SCT-010 y añadimos el valor obtenido de la calibración teórica
pinMode(analogpin, INPUT);
MonitorEnergia.current(34, 0.6);
// Imprimimos valores de Wifi
WiFi.begin(ssid, pass);
Serial.print("Conectando a ");
Serial.print(ssid);
while (WiFi.status() != WL_CONNECTED)
{
delay(500);
Serial.print(".");
}
Serial.println();
Serial.println("Conectado a WiFi");
Serial.print("Dirección IP: ");
Serial.println(WiFi.localIP());
z
  thing.add_wifi(ssid, pass);
 

  pinMode(FLOW_SENSOR_PIN, INPUT);
  attachInterrupt(digitalPinToInterrupt(FLOW_SENSOR_PIN), flow_sensor_isr, RISING);
}

void loop() {

Serial.print( "\t");
// Para el Irms y potencia iniciamente obtenemos el valor de la corriente eficaz y pasamos el número de muestras que queremos tomar
Irms = MonitorEnergia.calcIrms(1484);
// Calculamos la potencia aparente
potencia = Irms * voltajeRed;
// Mostramos la información por el monitor serie
Serial.print("Voltaje: ");
Serial.print(Irms,3);
Serial.print("A ");

  float flow_rate = pulse_count / FLOW_FACTOR;
  Serial.print("Caudal: ");
  Serial.print(flow_rate);
  Serial.println(" L/min");
  pulse_count = 0;
  delay(1000);

  thing["datos"] >> [&flow_rate](pson& in){
in["Consumo En Tiempo Real"] = flow_rate;
in["Potencia "]= Irms ;
};
thing.stream(thing["datos"]);
  thing.handle();
}