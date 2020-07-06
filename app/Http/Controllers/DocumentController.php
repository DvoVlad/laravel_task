<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;

class DocumentController extends Controller
{
	/**
	 * @Request $request
	 * return @array
	 * */
    public function create(Request $request)
    {
		$documentModel = new Document();
		$id = \Uuid::generate(4);
		$documentModel->id = $id;
		$documentModel->status = 'draft';
		$documentModel->payload = json_decode('{}');
		$documentModel->save();
		return ["document" => $documentModel];
	}
	
	/**
	 * @Document $doc - получаем документ по id
	 * @Request $request
	 * return @array
	 * */
	public function update(Document $doc, Request $request)
	{
		// Получаем json запрос от пользователя
		$jsonRequest = $request->getContent();
		// Устанавливаем заголовок ответа
		if($doc->status == 'draft'){
			// Преобразуем в массив
			$jsonToArray = json_decode($jsonRequest, true);
			// Проверяем payload на существование
			if(!array_key_exists('payload', $jsonToArray['document'])) {
				abort(400, "Not have payload field");
			}
			// получаем старое значение свойства payload
			$oldPayloadJsonToArray = (array)$doc->payload;
			// Складываем старое значение с новым и получаем результирующий массив
			$resultPayload = array_merge($oldPayloadJsonToArray, $jsonToArray['document']['payload']);
			// Обходим все поля со значением null и удаляем их
			foreach($resultPayload as $key => &$value) {
				if($value == null) {
					unset($resultPayload[$key]);
				}
				if(is_array($value)) {
					foreach($value as $key2 => $value2) {
						if($value2 == null) {
							unset($value[$key2]);
						}
					}
				}
			}
			// записываем изменение
			$doc->payload = $resultPayload;
			$doc->save();
			// Возвращаем json ответ
			return ["document" => $doc];
		} else {
			abort(400, "Document already published");
		}
	}
	
	/*
	 * @Document $doc - получаем документ по id
	 * return @array
	 * */
	public function publish(Document $doc)
	{
		if($doc->status == 'draft') {
			$doc->status = 'published';
			$doc->save();
		}
		return ["document" => $doc];
	}
	
	/*
	 * @Document $doc - получаем документ по id
	 * return @array
	 * */
	public function show(Document $doc)
	{
		return ["document" => $doc];
	}
	
	/*
	 * 
	 * */
	public function navShow(){
		$docs = Document::where("status","=","published")->paginate($_GET['perPage']);
		$resultItems = [];
		foreach($docs as $elems){
			$resultItems[] = $elems;
		}
		//dd($docs);
		return ['document' => $resultItems, 'pagination' => ["page" => $docs->currentPage(), "total" => $docs->total(), "perPage" => $docs->perPage()]];
	}
}
