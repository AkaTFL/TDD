<!-- Code effectué par Charles GROSSIN -->
<?php
    use PHPUnit\Framework\TestCase;

    require_once 'src/Teenager.php';
    require_once 'src/Account.php';
    require_once 'src/User.php';

    class TeenagerTest extends TestCase
    {
        private Account $account;
        
        protected function setUp(): void
        {
            $this->account = new Account();
        }

        public function testConstructor()
        {
            $teenager = new Teenager('John', $this->account, 15);
            
            $this->assertInstanceOf(Teenager::class, $teenager);
            $this->assertEquals('John', $teenager->getName());
            $this->assertEquals(15, $teenager->getAge());
        }

        public function testImplementsUser()
        {
            $teenager = new Teenager('John', $this->account, 15);
            
            $this->assertInstanceOf(User::class, $teenager);
        }

        public function testGetAccount()
        {
            $teenager = new Teenager('John', $this->account, 15);
            
            $this->assertInstanceOf(Account::class, $teenager->getAccount());
            $this->assertSame($this->account, $teenager->getAccount());
        }

        public function testWithdrawCash()
        {
            // Arrange
            $this->account->deposit(100);
            $teenager = new Teenager('John', $this->account, 15);
            
            // Act
            $remainingBalance = $teenager->withdrawCash(30);
            
            // Assert
            $this->assertEquals(70, $remainingBalance);
            $this->assertEquals(70, $this->account->getBalance());
        }

        public function testWithdrawMoney()
        {
            // Arrange
            $this->account->deposit(100);
            $teenager = new Teenager('John', $this->account, 15);
            
            // Act
            $remainingBalance = $teenager->withdrawMoney(25);
            
            // Assert
            $this->assertEquals(75, $remainingBalance);
            $this->assertEquals(75, $this->account->getBalance());
        }

        public function testWithdrawMoneyThrowsExceptionWhenInsufficientFunds()
        {
            // Arrange
            $this->account->deposit(10);
            $teenager = new Teenager('John', $this->account, 15);
            
            // Assert
            $this->expectException(Exception::class);
            $this->expectExceptionMessage("Insufficient funds");
            
            // Act
            $teenager->withdrawMoney(50);
        }

        public function testGetExpenses()
        {
            // Arrange
            $this->account->deposit(100);
            $teenager = new Teenager('John', $this->account, 15);
            $teenager->withdrawMoney(20);
            $teenager->withdrawMoney(15);
            
            // Act
            $expenses = $teenager->getExpenses();
            
            // Assert
            $this->assertIsArray($expenses);
            $this->assertCount(2, $expenses);
            $this->assertEquals(20, $expenses[0]['amount']);
            $this->assertEquals(15, $expenses[1]['amount']);
        }

        public function testConnect()
        {
            // Arrange
            $teenager = new Teenager('John', $this->account, 15);
            
            // Act
            $result = $teenager->connect();
            
            // Assert
            $this->assertTrue($result);
        }

        public function testSetWeeklyAllowance()
        {
            // Arrange
            $teenager = new Teenager('John', $this->account, 15);
            
            // Act
            $teenager->setWeeklyAllowance(25.50, 'Monday');
            
            // Assert
            $this->assertEquals(25.50, $teenager->getWeeklyAllowance());
            $this->assertEquals('Monday', $teenager->getAllowanceDay());
        }

        public function testGetWeeklyAllowanceReturnsNullWhenNotSet()
        {
            // Arrange
            $teenager = new Teenager('John', $this->account, 15);
            
            // Assert
            $this->assertNull($teenager->getWeeklyAllowance());
            $this->assertNull($teenager->getAllowanceDay());
        }
    }
?>