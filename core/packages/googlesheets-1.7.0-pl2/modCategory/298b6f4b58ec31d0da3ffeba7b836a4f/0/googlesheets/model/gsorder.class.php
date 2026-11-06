<?php

class gsOrder
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;
        $this->modx->lexicon->load('googlesheets:default');
           
    }
    
    // Получаем кол-во заказов
    public function getTotal($range)
    {
        $query = $this->modx->newQuery('msOrder');
        
        // Event: gsOnBeforeGetOrders
        $this->modx->invokeEvent('gsOnBeforeGetOrders', array(
            'query' => $query,
            'range' => $range,
        ));
        
        return $this->modx->getCount('msOrder', $query);
        
    }  
    
    // Получаем заказы
    public function getOrders($range, $fields = array(), $limit = 5000, $offset = 0)
    {
        
        $query = $this->modx->newQuery('msOrder');
        $query->limit($limit, $offset);
        $query->leftJoin('msOrderAddress', 'Address', 'msOrder.address = Address.id');
        
        $query->select($this->modx->getSelectColumns('msOrder', 'msOrder','', '', false));
        $query->select($this->modx->getSelectColumns('msOrderAddress', 'Address', 'address_', '', false));
        
        $query->leftJoin('modUser', 'User', 'msOrder.user_id = User.id');
        $query->select($this->modx->getSelectColumns('modUser', 'User', 'user_', '', false));
        
        $query->leftJoin('modUserProfile', 'UserProfile', 'msOrder.user_id = UserProfile.internalKey');
        $query->select($this->modx->getSelectColumns('modUserProfile', 'UserProfile', 'user_', '', false));

        foreach($fields as $field) {
            switch($field){
                case 'status_name':
                    $query->leftJoin('msOrderStatus', 'Status', 'msOrder.status = Status.id');
                    $query->select($this->modx->getSelectColumns('msOrderStatus', 'Status', 'status_', array('name'), false));        
                    break;
                case 'delivery_name':
                    $query->leftJoin('msDelivery', 'Delivery', 'msOrder.delivery = Delivery.id');
                    $query->select($this->modx->getSelectColumns('msDelivery', 'Delivery', 'delivery_', array('name'), false));
                    break;
                case 'payment_name':
                    $query->leftJoin('msPayment', 'Payment', 'msOrder.payment = Payment.id');
                    $query->select($this->modx->getSelectColumns('msPayment', 'Payment', 'payment_', array('name'), false));
                    break;
            }
        }
        
        // Event: gsOnBeforeGetOrders
        $this->modx->invokeEvent('gsOnBeforeGetOrders', array(
            'query' => $query,
            'range' => $range,
        ));
        
        $query->prepare();
        $query->stmt->execute();
        $orders = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Добавляем товары к заказу
        $orders = $this->addOrderProducts($range, $orders, $fields);
        
        // Event: gsOnGetOrders
        $this->modx->invokeEvent('gsOnGetOrders', array(
            'orders' => &$orders,
            'range' => $range,
        ));
        
        return $orders;
    }
    
    // Получаем продукты заказа
    public function getOrderProducts($id)
    {
        $products = array();
        $query = $this->modx->newQuery('msOrderProduct', array('order_id' => $id));
        $query->leftJoin('msProduct', 'Product', 'msOrderProduct.product_id = Product.id');
        $query->select($this->modx->getSelectColumns('msOrderProduct', 'msOrderProduct', '', '', false));
        $query->select($this->modx->getSelectColumns('msProduct', 'Product', '', '', false));
        if($query->prepare() && $query->stmt->execute()) {
            $products = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $products;
    }
    
    // Добавляем товары к заказу
    public function addOrderProducts($range, $orders, $fields)
    {
        $products = array_filter($fields, function($v) {
            if(preg_match('/^products_(\w+)/i', $v)) {
                return $v;
            }
        });
        
        foreach($orders as $key => $order) {
            if(!isset($order['id'])) continue;
            $dataProducts = $this->getOrderProducts($order['id']);
            foreach($products as $product) {
                $values = array();
                foreach($dataProducts as $data) {
                    $values[] = $data[str_replace('products_','',$product)] ?: '';
                }
                $orders[$key][$product] = implode(',',$values);
            }
        }
        
        return $orders;
    }
    
    // Получаем покупателей
    public function getClients($range)
    {
        $query = $this->modx->newQuery('msOrder');
        $query->select($this->modx->getSelectColumns('msOrder', 'msOrder','', '', false));
        
        $query->leftJoin('msOrderAddress', 'Address', 'msOrder.address = Address.id');
        $query->select($this->modx->getSelectColumns('msOrderAddress', 'Address', 'address_', '', false));
        
        $query->leftJoin('modUser', 'modUser', 'msOrder.user_id = modUser.id');
        $query->select($this->modx->getSelectColumns('modUser', 'modUser', 'user_', '', false));
        
        $query->leftJoin('modUserProfile', 'UserProfile', 'msOrder.user_id = UserProfile.internalKey');
        $query->select($this->modx->getSelectColumns('modUserProfile', 'UserProfile', 'user_', '', false));
        
        $query->groupby('msOrder.user_id');
        
        // Event: gsOnBeforeGetClients
        $this->modx->invokeEvent('gsOnBeforeGetClients', array(
            'query' => $query,
            'range' => $range,
        ));
        
        $query->prepare();
        $query->stmt->execute();
        $users = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Event^ gsOnGetClients
        $this->modx->invokeEvent('gsOnGetClients', array(
            'users' => &$users,
            'range' => $range,
        ));
        
        return $users;
    }
    
}    