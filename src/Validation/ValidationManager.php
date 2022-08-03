<?php


namespace Debuqer\TikaFormBuilder\Validation;

use Debuqer\TikaFormBuilder\Exceptions\InvalidValidationProvider;
use Symfony\Component\Validator\Constraints as Assert;
use Debuqer\TikaFormBuilder\DataStructure\Contracts\ValidationManagerInterface;
use Symfony\Component\Validator\Validation;

class ValidationManager implements ValidationManagerInterface
{
    protected $constraints = [
        'not-blank' => Assert\NotBlank::class,
        'blank' => Assert\Blank::class,
        'not-null' => Assert\NotNull::class,
        'is-null' => Assert\IsNull::class,
        'is-true' => Assert\IsTrue::class,
        'is-false' => Assert\IsFalse::class,
        'type' => Assert\Type::class,
        'email' => Assert\Email::class,
        'length' => Assert\Length::class,
        'url' => Assert\Url::class,
        'regex' => Assert\Regex::class,
        'hostname' => Assert\Hostname::class,
        'ip' => Assert\Ip::class,
        'cidr' => Assert\Cidr::class,
        'json' => Assert\Json::class,
        'uuid' => Assert\Uuid::class,
        'ulid' => Assert\Ulid::class,
        'css-color' => Assert\CssColor::class,
        'equal-to' => Assert\EqualTo::class,
        'not-equal-to' => Assert\NotEqualTo::class,
        'identical-to' => Assert\IdenticalTo::class,
        'not-identical-to' => Assert\NotIdenticalTo::class,
        'less-than' => Assert\LessThan::class,
        'less-than-or-equal' => Assert\LessThanOrEqual::class,
        'greater-than' => Assert\GreaterThan::class,
        'greater-than-or-equal' => Assert\GreaterThan::class,
        'range' => Assert\Range::class,
        'divisible-by' => Assert\DivisibleBy::class,
        'unique' => Assert\Unique::class,
        'positive' => Assert\Positive::class,
        'positive-or-zero' => Assert\PositiveOrZero::class,
        'negative' => Assert\Negative::class,
        'negative-or-zero' => Assert\NegativeOrZero::class,
        'date' => Assert\Date::class,
        'datetime' => Assert\DateTime::class,
        'time' => Assert\Time::class,
        'timezone' => Assert\Timezone::class,
        'choice' => Assert\Choice::class,
        'language' => Assert\Language::class,
        'locale' => Assert\Locale::class,
        'country' => Assert\Country::class,
        'file' => Assert\File::class,
        'image' => Assert\Image::class,
        'bic' => Assert\Bic::class,
        'card-scheme' => Assert\CardScheme::class,
        'currency' => Assert\Currency::class,
        'luhn' => Assert\Luhn::class,
        'iban' => Assert\Iban::class,
        'isbn' => Assert\Isbn::class,
        'issn' => Assert\Issn::class,
        'isin' => Assert\Isin::class,
        'at-least-one-of' => Assert\AtLeastOneOf::class,
        'sequentially' => Assert\Sequentially::class,
        'compound' => Assert\Compound::class,
        'callback' => Assert\Callback::class,
        'expression' => Assert\Expression::class,
        'all' => Assert\All::class,
        'valid' => Assert\Valid::class,
        'traverse' => Assert\Traverse::class,
        'collection' => Assert\Collection::class,
        'count' => Assert\Count::class,
    ];


    protected $validator;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var bool
     */
    protected $isValid = true;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    public function validate($data, $rules = [])
    {
        $this->errors = $this->validator->validate($data, $this->getConstraints($rules));

        $this->isValid = ( count($this->errors) == 0 );
    }

    public function isValid()
    {
        return $this->isValid;
    }

    public function getConstraints($rules)
    {
        $constraints = [];
        foreach ($rules as $key => $ruleList) {
            $itemConstraints = [];
            foreach ($ruleList as $ruleName => $ruleParameter) {
                $itemConstraints[] = $this->getItemConstraints($ruleName, $ruleParameter);
            }

            $constraints[$key] = new Assert\All($itemConstraints);
        }

        return $constraints;
    }

    protected function getItemConstraints($ruleName, $ruleParameters)
    {
        if( isset($this->constraints[$ruleName]) ) {
            $className = $this->constraints[$ruleName];

            return new $className($ruleParameters);
        } else {
            throw new InvalidValidationProvider(sprintf('validation %s is not valid', $ruleName));
        }
    }
}