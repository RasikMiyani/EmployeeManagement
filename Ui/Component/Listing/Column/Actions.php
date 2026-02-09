<?php
namespace Rasik\EmployeeManagement\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    protected UrlInterface $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        ...$args
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct(...$args);
    }

    public function prepareDataSource(array $dataSource)
    {
        foreach ($dataSource['data']['items'] as &$item) {
            $item[$this->getData('name')] = [
                'edit' => [
                    'label' => __('Edit'),
                    'href' => $this->urlBuilder->getUrl(
                        'employee/employee/edit',
                        ['entity_id' => $item['entity_id']]
                    )
                ],
                'delete' => [
                    'label' => __('Delete'),
                    'href' => $this->urlBuilder->getUrl(
                        'employee/employee/delete',
                        ['entity_id' => $item['entity_id']]
                    ),
                    'confirm' => [
                        'title' => __('Delete'),
                        'message' => __('Are you sure?')
                    ]
                ]
            ];
        }
        return $dataSource;
    }
}
