import 'package:flutter/material.dart';
import '../core/api_service.dart';

class ReturnScreen extends StatefulWidget {
  const ReturnScreen({super.key});

  @override
  State<ReturnScreen> createState() => _ReturnScreenState();
}

class _ReturnScreenState extends State<ReturnScreen> {
  final _apiService = ApiService();
  List<dynamic> _activeLoans = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchActiveLoans();
  }

  Future<void> _fetchActiveLoans() async {
    setState(() {
      _isLoading = true;
    });

    final response = await _apiService.getTransactions();

    if (response['success'] == true) {
      final List<dynamic> allTransactions = response['data'];
      setState(() {
        _activeLoans = allTransactions
            .where((tx) => tx['status'] == 'dipinjam')
            .toList();
        _isLoading = false;
      });
    } else {
      setState(() {
        _isLoading = false;
      });
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(response['message'] ?? 'Gagal mengambil data')),
        );
      }
    }
  }

  Future<void> _logout() async {
    await _apiService.logout();
    if (mounted) {
      Navigator.pushReplacementNamed(context, '/login');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Pengembalian Buku'),
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: _fetchActiveLoans,
          ),
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: _logout,
          ),
        ],
      ),
      body: RefreshIndicator(
        onRefresh: _fetchActiveLoans,
        child: _isLoading
            ? const Center(child: CircularProgressIndicator())
            : _activeLoans.isEmpty
                ? const Center(child: Text('Tidak ada buku yang sedang dipinjam'))
                : ListView.builder(
                    padding: const EdgeInsets.all(8.0),
                    itemCount: _activeLoans.length,
                    itemBuilder: (context, index) {
                      final tx = _activeLoans[index];
                      final book = tx['buku'];
                      final tglKembali = tx['tgl_kembali_rencana'];

                      return Card(
                        child: ListTile(
                          leading: const Icon(Icons.book, color: Colors.orange),
                          title: Text(book['judul'] ?? 'Buku'),
                          subtitle: Text('Batas Kembali: $tglKembali'),
                          trailing: ElevatedButton(
                            onPressed: () async {
                              final res = await _apiService.returnBook(tx['id']);
                              if (mounted) {
                                ScaffoldMessenger.of(context).showSnackBar(
                                  SnackBar(content: Text(res['message'])),
                                );
                                if (res['success'] == true) {
                                  _fetchActiveLoans(); // Refresh list
                                }
                              }
                            },
                            style: ElevatedButton.styleFrom(
                              backgroundColor: Colors.green,
                              foregroundColor: Colors.white,
                            ),
                            child: const Text('Kembalikan'),
                          ),
                        ),
                      );
                    },
                  ),
      ),
    );
  }
}
