<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

use App\Models\Customer;

class KafkaProducerSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:produce-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $container;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $topicConf = $this->container->get('KafkaTopicConfig');
        $brokerCollection = $this->container->get('KafkaBrokerCollection');

        $producer = new \PHPEasykafka\KafkaProducer(
            $brokerCollection, 'orders', $topicConf); 
        
        $order = $this->fakeOrder();

        $producer->produce(json_encode($order));
    }

    public function fakeOrder()
    {
        $customer_id = Uuid::uuid4();
        Customer::create(
            [
                'id'    => $customer_id,
                'name'  => 'Jose - '.$customer_id,
                'email' => 'jose-'.$customer_id.'@gmail.com',
                'phone' => '99999-9999'
            ]
        );

        $product_id = Uuid::uuid4();
        $order_id   = Uuid::uuid4();

        $order = [
            'order' => [
                'id' => $order_id,
                'customer_id' => $customer_id,
                'status' => 'reservado',
                'discount' => 5,
                'total' => 95,
                'order_date' => '2020-05-24',
                'return_date' => '2020-05-28',
                'items' => [
                    [
                        'id' => Uuid::uuid4(),
                        'order_id' => $order_id,
                        'product' => [
                            'id' => $product_id,
                            'name' => 'Product name',
                        ],
                        'qtd' => 1,
                        'total' => 100
                    ]
                ]
            ]
        ];

        return $order;
    }
}
