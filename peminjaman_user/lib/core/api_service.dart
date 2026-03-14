import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'constants.dart';

class ApiService {
  Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('auth_token');
  }

  Future<void> saveToken(String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
  }

  Future<void> removeToken() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
  }

  Future<Map<String, String>> _getHeaders() async {
    final token = await getToken();
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }

  Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse(Constants.baseUrl + Constants.loginEndpoint),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({'email': email, 'password': password}),
      );

      return jsonDecode(response.body);
    } catch (e) {
      return {'success': false, 'message': 'Terjadi kesalahan jaringan'};
    }
  }

  Future<Map<String, dynamic>> logout() async {
    try {
      final response = await http.post(
        Uri.parse(Constants.baseUrl + Constants.logoutEndpoint),
        headers: await _getHeaders(),
      );

      await removeToken();
      return jsonDecode(response.body);
    } catch (e) {
      return {'success': false, 'message': 'Terjadi kesalahan jaringan'};
    }
  }

  Future<Map<String, dynamic>> getBooks() async {
    try {
      final response = await http.get(
        Uri.parse(Constants.baseUrl + Constants.bukuEndpoint),
        headers: await _getHeaders(),
      );

      return jsonDecode(response.body);
    } catch (e) {
      return {'success': false, 'message': 'Terjadi kesalahan jaringan'};
    }
  }

  Future<Map<String, dynamic>> getTransactions() async {
    try {
      final response = await http.get(
        Uri.parse(Constants.baseUrl + Constants.transaksiEndpoint),
        headers: await _getHeaders(),
      );

      return jsonDecode(response.body);
    } catch (e) {
      return {'success': false, 'message': 'Terjadi kesalahan jaringan'};
    }
  }

  Future<Map<String, dynamic>> borrowBook(int bukuId, [int lamaPinjam = 7]) async {
    try {
      final response = await http.post(
        Uri.parse(Constants.baseUrl + Constants.transaksiEndpoint),
        headers: await _getHeaders(),
        body: jsonEncode({
          'buku_id': bukuId,
          'lama_pinjam': lamaPinjam,
        }),
      );

      return jsonDecode(response.body);
    } catch (e) {
      return {'success': false, 'message': 'Terjadi kesalahan jaringan'};
    }
  }
}
