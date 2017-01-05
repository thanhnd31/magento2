<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/15/2016
 * Time: 9:39 AM
 */

namespace ThanhND\SliderWidget\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\LayoutFactory;
use ThanhND\SliderWidget\Controller\Adminhtml\BannerAbstract;
use ThanhND\SliderWidget\Model\BannerFactory;
use ThanhND\SliderWidget\Model\ImageUploader;

class Save extends BannerAbstract
{
    protected $imageUploader;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        LayoutFactory $resultLayoutFactory,
        ImageUploader $imageUploader,
        BannerFactory $bannerFactory)
    {
        parent::__construct($context, $coreRegistry, $resultPageFactory, $resultLayoutFactory, $bannerFactory);
        $this->imageUploader = $imageUploader;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if($data)
        {
            try {
                /** @var \ThanhND\FooterLinks\Model\Link $model */
                $model = $this->_bannerFactory->create();

                $bannerData = $data["general"];

                // Save image
                $image = $this->_imageUploader($bannerData);
                $bannerData['image'] = $image;

                $bannerId = isset($bannerData["banner_id"]) ? $bannerData["banner_id"]:null;
                if ($bannerId) {
                    $banner = $model->load($bannerId)->getData();
                    $bannerData = array_merge($banner,$bannerData);
                }

                // Update time
                $updateTime = date('Y-m-d H:i:s');
                if (!isset($bannerData["creation_time"]))
                {
                    $bannerData["creation_time"] = $updateTime;
                }
                $bannerData["update_time"] = $updateTime;

                $model->setData($bannerData);
                $model->save();

                $this->messageManager->addSuccess(__('Banner saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the banner'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function _imageUploader($bannerData)
    {
        $image = $bannerData['image'][0]['name'];
        if(count($bannerData['image'][0]) > 2)
        {
            $this->imageUploader->moveFileFromTmp($image);
        }

        return $image;
    }
}