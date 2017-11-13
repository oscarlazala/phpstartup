<?php

class Printer
{
	private $queue = [];
	private $maxQueuedDocuments = 10;

	public function print(Document $document)
	{
		return $this->pushToQueue($document);
	}

	private function pushToQueue(Document $newDocument)
	{
		if(  count($this->queue) < $this->maxQueuedDocuments) {
			$this->queue[] = $newDocument;
			return true;
		}

		return false;
	}
}

class MultiFunctionPrinter extends Printer
{
	public function copy()
	{

	}

	public function scan()
	{

	}
}

// print()
// copy()
// scan()
//
// events:
//  onPaperJammed()
//  onLowInk()

interface Document
{

}

class Print
{
	protected $printerName = 'Printer01';

	public static function print(Document $document, ?String $printer)
	{
		$printJob = new static;

		if ($printer) {
			$printJob->setPrinter($printer);
		}

		return $printJob->getPrinter()
			->print($document)
			->then(function () {

			});
	}

	protected function getPrinter(): Printer
	{
		$printer = new $this->printerName();

		if ( ! ($printer instanceof Printer)) {
			throw new Exception("Not a valid printer selected.", 1);
		}

		return $printer;
	}

	protected function setPrinter(String $printer)
	{
		$this->printerName = $printer;
	}
}

$document1 = new Document();
Print::print($document1);

Printer::worker();

$document2 = new Document();
Print::print($document2);

$document3 = new Document();
Print::print($document3);

Printer::worker();

echo Printer::getQueuedJobs();

