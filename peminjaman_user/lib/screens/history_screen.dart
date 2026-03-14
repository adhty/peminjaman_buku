import 'package:flutter/material.dart';
import '../core/api_service.dart';

class HistoryScreen extends StatefulWidget {
  const HistoryScreen({super.key});

  @override
  State<HistoryScreen> createState() => _HistoryScreenState();
}

class _HistoryScreenState extends State<HistoryScreen> {
  final _apiService = ApiService();
  List<dynamic> _transactions = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchHistory();
  }

  Future<void> _fetchHistory() async {
    setState(() {
      _isLoading = true;
    });

    final response = await _apiService.getTransactions();

    if (response['success'] == true) {
      setState(() {
        _transactions = response['data'];
        _isLoading = false;
      });
    } else {
      setState(() {
        _isLoading = false;
      });
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(response['message'] ?? 'Gagal mengambil riwayat')),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Riwayat Peminjaman'),
      ),
      body: RefreshIndicator(
        onRefresh: _fetchHistory,
        child: _isLoading
            ? const Center(child: CircularProgressIndicator())
            : _transactions.isEmpty
                ? const Center(child: Text('Belum ada riwayat peminjaman'))
                : ListView.builder(
                    padding: const EdgeInsets.all(8.0),
                    itemCount: _transactions.length,
                    itemBuilder: (context, index) {
                      final tx = _transactions[index];
                      final book = tx['buku'];
                      final status = tx['status'];
                      final tglPinjam = tx['tgl_pinjam'];
                      final tglKembali = tx['tgl_kembali_rencana'];

                      Color statusColor = Colors.blue;
                      if (status == 'dikembalikan') statusColor = Colors.green;
                      if (status == 'terlambat') statusColor = Colors.red;

                      return Card(
                        child: ListTile(
                          title: Text(book['judul'] ?? 'Buku'),
                          subtitle: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text('Pinjam: $tglPinjam'),
                              Text('Batas Kembali: $tglKembali'),
                              if (tx['tgl_kembali_aktual'] != null)
                                Text('Dikembalikan: ${tx['tgl_kembali_aktual']}'),
                            ],
                          ),
                          trailing: Container(
                            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                            decoration: BoxDecoration(
                              color: statusColor.withOpacity(0.1),
                              borderRadius: BorderRadius.circular(4),
                              border: Border.all(color: statusColor),
                            ),
                            child: Text(
                              status.toUpperCase(),
                              style: TextStyle(color: statusColor, fontWeight: FontWeight.bold, fontSize: 10),
                            ),
                          ),
                        ),
                      );
                    },
                  ),
      ),
    );
  }
}
