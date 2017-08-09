<?php
use PHPUnit\Framework\TestCase;

use Wienkit\BolPlazaClient\Requests\BolPlazaUpsertRequest;
use Wienkit\BolPlazaClient\Entities\BolPlazaCancellation;
use Wienkit\BolPlazaClient\Entities\BolPlazaShipmentRequest;
use Wienkit\BolPlazaClient\Entities\BolPlazaTransport;
use Wienkit\BolPlazaClient\Entities\BolPlazaChangeTransportRequest;
use Wienkit\BolPlazaClient\Entities\BolPlazaReturnItemStatusUpdate;
use Wienkit\BolPlazaClient\Entities\BolPlazaRetailerOffer;
use Wienkit\BolPlazaClient\BolPlazaClient;

class BolPlazaClientTest extends TestCase
{
    /**
     * @var Wienkit\BolPlazaClient\BolPlazaClient
     */
    private $client;

    public function setUp()
    {
        $publicKey = getenv('PHP_PUBKEY');
        $privateKey = getenv('PHP_PRIVKEY');

        $this->client = new BolPlazaClient($publicKey, $privateKey);
        $this->client->setTestMode(true);
    }

    public function testOrderRetrieve()
    {
        $orders = $this->client->getOrders();
        $this->assertNotEmpty($orders);
        return $orders;
    }

    /**
     * @param array $orders
     * @depends testOrderRetrieve
     */
    public function testOrdersComplete(array $orders)
    {
        $this->assertEquals(count($orders), 2);
        $this->assertEquals(count($orders[0]->OrderItems), 1);
        $this->assertEquals($orders[0]->OrderItems[0]->OrderItemId, '123');
        $this->assertEquals($orders[0]->CustomerDetails->ShipmentDetails->HousenumberExtended, 'bis');
        $this->assertEquals($orders[0]->CustomerDetails->ShipmentDetails->AddressSupplement, '3 hoog achter');
        $this->assertEquals($orders[0]->CustomerDetails->ShipmentDetails->ExtraAddressInformation, 'extra adres info');
        $this->assertEquals(count($orders[1]->OrderItems), 1);
        $this->assertEquals($orders[1]->OrderItems[0]->OrderItemId, '123');
    }

    /**
     * @depends testOrderRetrieve
     * @param array $orders
     */
    public function testOrderItemCancellation(array $orders)
    {
        $orderItem = $orders[0]->OrderItems[0];
        $cancellation = new BolPlazaCancellation();
        $cancellation->DateTime = '2011-01-01T12:00:00';
        $cancellation->ReasonCode = 'REQUESTED_BY_CUSTOMER';
        $result = $this->client->cancelOrderItem($orderItem, $cancellation);
        $this->assertEquals($result->eventType, 'CANCEL_ORDER');
    }

    public function testProcessShipments()
    {
        $shipment = new BolPlazaShipmentRequest();
        $shipment->OrderItemId = '123';
        $shipment->ShipmentReference = 'bolplazatest123';
        $shipment->DateTime = date('Y-m-d\TH:i:s');
        $shipment->ExpectedDeliveryDate = date('Y-m-d\TH:i:s');
        $transport = new BolPlazaTransport();
        $transport->TransporterCode = 'GLS';
        $transport->TrackAndTrace = '123456789';
        $shipment->Transport = $transport;
        $result = $this->client->processShipment($shipment);
        $this->assertEquals($result->eventType, 'CONFIRM_SHIPMENT');
    }

    public function testGetShipments()
    {
        $shipments = $this->client->getShipments();
        $this->assertEquals(count($shipments), 2);
        return $shipments;
    }

    public function testGetReturnItems()
    {
        $returnItems = $this->client->getReturnItems();
        $this->assertEquals(count($returnItems), 1);
        $this->assertEquals($returnItems[0]->ReturnNumber, "0");
        $this->assertEquals($returnItems[0]->OrderId, "1");
        $this->assertEquals($returnItems[0]->EAN, "Test EAN");
        $this->assertEquals($returnItems[0]->Quantity, "2");
        return $returnItems;
    }

    /**
     * @depends testGetReturnItems
     * @param array $returnItems
     */
    public function testHandleReturnItem(array $returnItems)
    {
        $returnItem = $returnItems[0];
        $returnStatus = new BolPlazaReturnItemStatusUpdate();
        $returnStatus->StatusReason = 'PRODUCT_RECEIVED';
        $returnStatus->QuantityReturned = '2';
        $result = $this->client->handleReturnItem($returnItem, $returnStatus);
        $this->assertEquals($result->eventType, 'HANDLE_RETURN_ITEM');
    }

    /**
     * @depends testGetShipments
     * @param array $shipments
     */
    public function testChangeTransport(array $shipments)
    {
        $shipment = $shipments[0];
        $changeRequest = new BolPlazaChangeTransportRequest();
        $changeRequest->TransporterCode = '3SNEW941245';
        $changeRequest->TrackAndTrace = 'DPD-BE';
        $result = $this->client->changeTransport($shipment, $changeRequest);
        $this->assertEquals($result->eventType, 'CHANGE_TRANSPORT');
    }

    public function testGetPayments()
    {
        $period = '201601';
        $payments = $this->client->getPayments($period);
        $this->assertEquals(count($payments), 2);
    }

    public function testGetProcessStatus()
    {
        $processStatusId = '1';
        $result = $this->client->getProcessStatus($processStatusId);
        $this->assertEquals($result->eventType, 'CHANGE_TRANSPORT');
    }

    public function testCreateOffer()
    {
        $upsertRequest = new BolPlazaUpsertRequest();
        $offer = new BolPlazaRetailerOffer();
        $offer->EAN = '9789076174082';
        $offer->Condition = 'REASONABLE';
        $offer->Price = '7.50';
        $offer->DeliveryCode = '3-5d';
        $offer->Publish = 'true';
        $offer->ReferenceCode = 'HarryPotter-2ehands';
        $offer->QuantityInStock = 1;
        $offer->Description = 'boek met koffievlekken';
        $offer->Title = '';
        $offer->FulfillmentMethod = 'FBR';
        $upsertRequest->RetailerOffer = $offer;
        $exceptionThrown = false;
        try {
            $this->client->createOffer($upsertRequest);
        } catch (Exception $e) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    public function testCreateBulkOffer()
    {
        $upsertRequest = new BolPlazaUpsertRequest();

        $offer = new BolPlazaRetailerOffer();
        $offer->EAN = '9789076174082';
        $offer->Condition = 'REASONABLE';
        $offer->Price = '7.50';
        $offer->DeliveryCode = '3-5d';
        $offer->Publish = 'true';
        $offer->ReferenceCode = 'HarryPotter-2ehands';
        $offer->QuantityInStock = 1;
        $offer->Description = 'boek met koffievlekken';
        $offer->Title = '';
        $offer->FulfillmentMethod = 'FBR';

        $offer2 = new BolPlazaRetailerOffer();
        $offer2->EAN = '9789043009614';
        $offer2->Condition = 'NEW';
        $offer2->Price = '9.95';
        $offer2->DeliveryCode = '1-2d';
        $offer2->Publish = 'true';
        $offer2->ReferenceCode = '9789043009614';
        $offer2->QuantityInStock = 5;
        $offer2->Description = 'PHP en MYSQL voor Dummies';
        $offer2->Title = '';
        $offer2->FulfillmentMethod = 'FBR';

        $upsertRequest->RetailerOffer = [$offer, $offer2];

        $exceptionThrown = false;
        try {
            $this->client->createOffer($upsertRequest);
        } catch (Exception $e) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    public function testUpdateOffer()
    {
        $upsertRequest = new BolPlazaUpsertRequest();
        $offer = new BolPlazaRetailerOffer();
        $offer->EAN = '9789076174082';
        $offer->Condition = 'NEW';
        $offer->Price = '12.00';
        $offer->DeliveryCode = '24uurs-16';
        $offer->Publish = 'true';
        $offer->ReferenceCode = 'HarryPotter-2ehands';
        $offer->QuantityInStock = 1;
        $offer->Description = 'boek met koffievlekken';
        $upsertRequest->RetailerOffer = $offer;
        $exceptionThrown = false;
        try {
            $this->client->updateOffer($upsertRequest);
        } catch (Exception $e) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    public function testUpdateOfferStock()
    {
        $upsertRequest = new BolPlazaUpsertRequest();
        $offer = new BolPlazaRetailerOffer();
        $offer->EAN = '9789076174082';
        $offer->Condition = 'REASONABLE';
        $offer->Price = '12.00';
        $offer->DeliveryCode = '24uurs-16';
        $offer->Publish = 'true';
        $offer->ReferenceCode = 'HarryPotter-2ehands';
        $offer->QuantityInStock = 2;
        $offer->Description = 'boek met koffievlekken';
        $upsertRequest->RetailerOffer = $offer;
        $exceptionThrown = false;
        try {
            $this->client->updateOfferStock($upsertRequest);
        } catch (Exception $e) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    public function testDeleteOffer()
    {
        $exceptionThrown = false;
        try {
            $this->client->deleteOffer('9789076174082', 'REASONABLE');
        } catch (Exception $e) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    /**
     * TODO: Receives access denied
     */
    public function ignoredTestGetCommission()
    {
        $exceptionThrown = false;
        try {
            $this->client->getCommission('9789076174082', 'REASONABLE', 100);
        } catch (Exception $e) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    public function testGetOwnOffers()
    {
        $result = $this->client->getOwnOffers();
        $this->assertEquals($result->Url, 'https://test-plazaapi.bol.com/offers/v2/export/offers.csv');
        return $result->Url;
    }

    /**
     * @TODO: Ignored because Test env returns other logic than prod
     */
    public function ignoreTestGetValidationError()
    {
        $upsertRequest = new BolPlazaUpsertRequest();
        $offer = new BolPlazaRetailerOffer();
        $offer->EAN = '9789076174082';
        $offer->Condition = 'REASONABLE';
        $offer->Price = '12.00';
        $offer->DeliveryCode = '125uurs-16';
        $offer->Publish = 'true';
        $offer->ReferenceCode = 'HarryPotter-2ehands';
        $offer->QuantityInStock = 750000;
        $upsertRequest->RetailerOffer = $offer;
        try {
            $this->client->createOffer($upsertRequest);
            $this->fail();
        } catch (\Exception $e) {
            assertTrue(true);
        }
    }

    /**
     * @param $url
     * @depends testGetOwnOffers
     */
    public function testGetOwnOffersResult($url)
    {
        $result = $this->client->getOwnOffersResult($url);
        self::assertNotNull($result);
        self::assertStringStartsWith("OfferId,", $result);
    }

    /**
     * @TODO: Ignored because Test env returns other logic than prod
     */
    public function testGetSingleOffer()
    {
//        $eancode = '1234567890123';
//        try {
//            $result = $this->client->getSingleOffer($eancode);
//        } catch (\Exception $e) {
//            $result = null;
//        }
//        $this->assertNotNull($result);
//        $this->assertEquals($result->EAN, $eancode);
    }
    /**
     * Test Get Inventory
     */
    public function testGetInventory()
    {
        $inventory = $this->client->getInventory();
        $this->assertNotEmpty($inventory);
        return $inventory;
    }


    /**
     * Test Get Latest Reductions Filename
     */
    public function testGetLatestReductionsFilename()
    {
        $filename = $this->client->getLatestReductionsFilename();
        $this->assertNotNull($filename);
    }

    /**
     * Test Get Reductions
     */
    public function testGetReductions()
    {
        $reductions = $this->client->getReductions();
        $this->assertNotNull($reductions->getFilename());
        $this->assertNotNull($reductions->getData());
    }
}
