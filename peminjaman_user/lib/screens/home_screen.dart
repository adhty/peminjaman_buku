import 'package:flutter/material.dart';
import '../core/api_service.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final _apiService = ApiService();
  List<dynamic> _books = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchBooks();
  }

  Future<void> _fetchBooks() async {
    setState(() {
      _isLoading = true;
    });

    final response = await _apiService.getBooks();

    if (response['success'] == true) {
      setState(() {
        _books = response['data'];
        _isLoading = false;
      });
    } else {
      setState(() {
        _isLoading = false;
      });
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(response['message'] ?? 'Gagal mengambil data buku')),
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
        title: const Text('Katalog Buku'),
        actions: [
          IconButton(
            icon: const Icon(Icons.history),
            tooltip: 'Riwayat Pinjam',
            onPressed: () => Navigator.pushNamed(context, '/history'),
          ),
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: _fetchBooks,
          ),
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: _logout,
          ),
        ],
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _books.isEmpty
              ? const Center(child: Text('Tidak ada buku tersedia'))
              : ListView.builder(
                  padding: const EdgeInsets.all(8.0),
                  itemCount: _books.length,
                  itemBuilder: (context, index) {
                    final book = _books[index];
                    final int stok = book['stok'] ?? 0;
                    final bool isAvailable = stok > 0;

                    return Card(
                      elevation: 2,
                      margin: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 4.0),
                      child: ListTile(
                        leading: Container(
                          width: 50,
                          height: 70,
                          color: Colors.blue[50],
                          child: const Icon(Icons.book, color: Colors.blue),
                        ),
                        title: Text(
                          book['judul'] ?? 'Tanpa Judul',
                          style: const TextStyle(fontWeight: FontWeight.bold),
                        ),
                        subtitle: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text('Pengarang: ${book['pengarang'] ?? '-'}'),
                            const SizedBox(height: 4),
                            Text(
                              isAvailable ? 'Stok: $stok' : 'Habis',
                              style: TextStyle(
                                color: isAvailable ? Colors.green : Colors.red,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ],
                        ),
                        isThreeLine: true,
                        trailing: ElevatedButton(
                          onPressed: isAvailable
                              ? () async {
                                  // We no longer need to pass anggota_id here because 
                                  // it is automatically handled by the Laravel backend via Auth
                                  final res = await _apiService.borrowBook(book['id']);
                                  if (mounted) {
                                    ScaffoldMessenger.of(context).showSnackBar(
                                      SnackBar(content: Text(res['message'])),
                                    );
                                    if (res['success'] == true) {
                                      _fetchBooks(); // Refresh list
                                    }
                                  }
                                }
                              : null,
                          child: const Text('Pinjam'),
                        ),
                      ),
                    );
                  },
                ),
    );
  }
}
