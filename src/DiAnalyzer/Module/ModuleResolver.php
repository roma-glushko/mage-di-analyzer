<?php

declare(strict_types=1);

namespace DiAnalyzer\Module;

/**
 *
 */
class ModuleResolver
{
    static private $moduleMatchMap = [
        'Magento_CatalogRule' => ['catalogRule', 'CatalogRule'],
        'Magento_Elasticsearch' => ['elasticsearch'],
        'Magento_AuthorizenetAcceptjs' => ['AuthorizenetAcceptjs'],
        'ClassyLlama_AvaTax' => ['AvaTax'],
        'Magento_Eway' => ['Eway'],
        'Magento_Cybersource' => ['Cybersource'],
        'Magento_Worldpay' => ['Worldpay'],
        'Magento_Braintree' => ['Braintree'],
        'Amazon_Payment' => ['Amazon'],
        'Magento_Signifyd' => ['Signifyd'],
        'Magento_Directory' => ['Directory'],
        'Magento_Sales' => ['SalesOrder', 'SalesInvoice', 'SalesCreditmemo', 'SalesShipment'],
        'Magento_SalesArchive' => ['SalesArchive'],
        'Magento_RequireJs' => ['requirejs'],
        'Magento_Config' => ['systemConfig'],
        'Magento_CmsStaging' => ['stagingCmsPage'],
        'Magento_CatalogStaging' => ['stagingCatalog', 'catalogCategoryStaging'],
        'Magento_CategoryPermissions' => ['categoryPermissions'],
        'Magento_Ui' => ['uiComponent', 'uiDefinition'],
        'Magento_Developer' => [
            'cssMinification',
            'jsMinification',
            'cssSource',
            'AssetRepository',
            'AssetSource',
            'AssetPre',
        ],
        'Magento_Paypal' => ['PayflowPro', 'Payflowpro', 'payflowpro', 'payflow'],
        'Magento_Framework' => [
            'layoutArgument',
            'layoutArrayArgument',
            'layoutObject',
            'pageLayoutFileSource',
            'layoutFileSource',
            'pageFileSource',
        ],
        'Klarna_Kp' => ['Kp', 'KP', 'Klarna'],
        'MageWorx_SeoXTemplates' => ['MageWorxSeoXTemplates'],
        'MageWorx_SeoReports' => ['MageWorxSeoreports'],
        'MageWorx_SeoRedirects' => ['MageWorxSeoRedirects'],
        'Astound_Affirm' => ['Affirm', 'OnePica'],
    ];

    /**
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function resolve(string $instanceType): string
    {

        // is this a classname?
        if (strpos($instanceType, "\\") !== false) {
            $explodedClassname = explode('\\', $instanceType);
            $moduleName = $explodedClassname[0] . '_' . $explodedClassname[1];

            return $moduleName;
        }

        // try to find to which module this instance type belongs
        foreach (static::$moduleMatchMap as $moduleName => $instancePatterns) {
            foreach ($instancePatterns as $instancePattern) {
                if (strpos($instanceType, $instancePattern) !== false) {
                    return $moduleName;
                }
            }
        }

        return $instanceType;
    }
}