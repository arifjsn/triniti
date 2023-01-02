<?php

if (isset($_POST["action"])) {
	$file = '../data.json';

	if ($_POST['action'] == 'Tambah' || $_POST['action'] == 'Edit') {
		$error = array();

		$data = array();

		$file_data = json_decode(file_get_contents($file), true);

		$data['id'] = count($file_data) + 1;

		if (empty($_POST['nama'])) {
			$error['nama_error'] = 'nama tidak boleh kosong';
		} else {
			$data['nama'] = trim($_POST['nama']);
		}

		if (empty($_POST['url'])) {
			$error['url_error'] = 'url tidak boleh kosong';
		} else {
			$data['url'] = trim($_POST['url']);
		}

		if (count($error) > 0) {
			$output = array(
				'error'		=>	$error
			);
		} else {
			$file_data = json_decode(file_get_contents($file), true);

			if ($_POST['action'] == 'Tambah') {

				$file_data[] = $data;

				file_put_contents($file, json_encode($file_data));

				$output = array(
					'success' => 'Data berhasil ditambah'
				);
			}

			if ($_POST['action'] == 'Edit') {
				$key = array_search($_POST['id'], array_column($file_data, 'id'));

				$file_data[$key]['nama'] = $data['nama'];

				$file_data[$key]['url'] = $data['url'];

				file_put_contents($file, json_encode($file_data));

				$output = array(
					'success' => 'Data berhasil diedit'
				);
			}
		}

		echo json_encode($output);
	}

	if ($_POST['action'] == 'fetch_single') {
		$file_data = json_decode(file_get_contents($file), true);

		$key = array_search($_POST["id"], array_column($file_data, 'id'));

		echo json_encode($file_data[$key]);
	}

	if ($_POST['action'] == 'delete') {
		$file_data = json_decode(file_get_contents($file), true);

		$key = array_search($_POST['id'], array_column($file_data, 'id'));

		unset($file_data[$key]);

		file_put_contents($file, json_encode($file_data));

		echo json_encode(['success' => 'Data berhasil dihapus']);
	}
}
