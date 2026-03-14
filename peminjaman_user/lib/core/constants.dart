class Constants {
  // Use 10.0.2.2 for Android Emulator to connect to localhost,
  // or your actual local IP address (e.g. 192.168.1.x) if using real device.
  // For Windows development, localhost or 127.0.0.1 might work depending on the setup.
  static const String baseUrl = 'http://127.0.0.1:8000/api';
  
  // Endpoints
  static const String loginEndpoint = '/login';
  static const String logoutEndpoint = '/logout';
  static const String userEndpoint = '/user';
  static const String bukuEndpoint = '/buku';
  static const String transaksiEndpoint = '/transaksi';
}
