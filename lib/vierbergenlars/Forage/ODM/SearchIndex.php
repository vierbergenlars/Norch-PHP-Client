<?php

namespace vierbergenlars\Forage\ODM;

use vierbergenlars\Forage\SearchIndex\Index;
use vierbergenlars\Forage\Transport\TransportInterface;

/**
 * A search index that can index object
 */
class SearchIndex extends Index
{

    /**
     * The hydration settings
     * @var \vierbergenlars\Forage\ODM\HydrationSettingsInterface
     */
    protected $hydrationSettings;

    /**
     * @internal
     * @param \vierbergenlars\Forage\Transport\TransportInterface $transport
     * @param \vierbergenlars\Forage\ODM\HydrationSettingsInterface $hydrationSettings
     */
    public function __construct(TransportInterface $transport,
                                HydrationSettingsInterface $hydrationSettings)
    {
        $this->hydrationSettings = $hydrationSettings;
        parent::__construct($transport);
    }

    /**
     * {@inheritDoc}
     *
     * @param object $document
     * @param null $_ Unused parameter
     * @return \vierbergenlars\Forage\ODM\SearchIndex
     */
    public function addDocument($document, $_ = null)
    {
        parent::addDocument(
            $this->hydrationSettings->getDocumentId($document),
            $this->hydrationSettings->getDocument($document)
        );
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @param object|string|int $document
     *      When the document to remove is given as a string or an integer,
     *      it is used as an id. If it is an object, {@link HydrationSettingsInterface::getDocument()}
     *      gets called, and the document id will be determined from the returned array.
     * @param null $_ Unused parameter
     * @return \vierbergenlars\Forage\ODM\SearchIndex
     */
    public function removeDocument($document, $_ = null)
    {
        if(is_object($document)) {
            parent::removeDocument(
                $this->hydrationSettings->getDocumentId($document)
            );
        } else {
            parent::removeDocument($document);
        }
        return $this;
    }

}
